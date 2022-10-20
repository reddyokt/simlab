$(function(){
    var tableDtm = $('#dtM').DataTable({
        responsive: false,
        pageLength: 10,
        // Pagination settings
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
        <'row'<'col-sm-12'tr>>
        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        headerCallback: function(thead, data, start, end, display) {
            thead.getElementsByTagName('th')[0].innerHTML = `
                <label class="checkbox checkbox-single">
                    <input type="checkbox" id="selectAllMhs" class="group-checkable"/>
                    <span></span>
                </label>`;
        },
        columnDefs: [
            {
                targets: 0,
                width: '30px',
                className: 'dt-left',
                orderable: false,
                render: function(data, type, full, meta) {
                    var f = full[0];
                    f = f.split(" ");
                    var fx = f[2].match(/"([^"]+)"/)[1];
                    var str1 = '<label class="checkbox checkbox-single">';
                    var str2 = '<input type="checkbox" class="checkable" value="'+$('<div/>').text(fx).html()+'">';
                    var str3 = '<span></span>';
                    var str4 = '</label>';
                    return str1+str2+str3+str4;
                },
            }
        ],
        buttons: []
    });

    var allPages = tableDtm.cells().nodes();
    $('#dtM').on('click','#selectAllMhs', function(){
        var data = [];
        if ($(this).hasClass('checkable')) {
            $(allPages).find('input[type="checkbox"]').prop('checked', false);
        } else {
            $(allPages).find('input[type="checkbox"]').prop('checked', true);
        }
        $(this).toggleClass('checkable');
        // Get all rows with search applied
        var rows = tableDtm.$('tr', {"filter": "applied"});// viewlist is
        var checked = $(this).prop('checked');
        var data = [];
        $.each(rows, function () {
            var checkbox = $($(this).find('td').eq(0)).find('input').prop('checked', checked);
            if(checked){
                var a = parseInt(checkbox.val());
                data.push(a);
            }
        });

        window.localStorage['data_mhs'] = JSON.stringify(data);
    });

    var rows = tableDtm.$('tr', {"filter": "applied"});// viewlist is
    $('input[type="checkbox"]', rows).each(function(i,e){
        $(e).click(function(){
            var checkBoxC = [];
            var cbChecked = JSON.parse(window.localStorage['data_mhs']);
            var val = parseInt($(e).val());

            if($(e).is(':checked')){
                if($.inArray(val, cbChecked) === -1){
                    cbChecked.push(val);
                }
            }else{
                var index = cbChecked.indexOf(val);
                if(index > -1){
                    cbChecked.splice(index,1);
                }
                $('#selectAllMhs').prop('checked', false);
            }

            window.localStorage['data_mhs'] = JSON.stringify(cbChecked);
        });
    });

    $(document).on('submit', '#form_add_manual', function(){
        var url = "/kelompok/store";
        var form_data = $("#form_add_manual").serializeArray();
        var data_mhs = window.localStorage['data_mhs'];

        form_data.push({name: 'mhs', value: data_mhs});

        var locale = $('html').attr('lang');
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var jsonfile = baseUrl+'/assets/'+locale+'.json';

        $.getJSON(jsonfile, function(json) {
            Swal.fire({
                title: json.title_alert_confirm,
                text: json.text_alert_pbl,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: json.btn_alert_confirm,
                cancelButtonText: json.btn_alert_cancel,
            })
            .then(function(result){
                if(result.value){
                    Swal.fire({
                        title: "Harap tunggu",
                        text: "Sedang memroses...",
                        icon: "info",
                        buttons: false,
                    });
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: form_data,
                        url: url,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status) {
                                Swal.fire({
                                    title: json.title_alert_success,
                                    text: data.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: json.btn_alert_ok,
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function (result) {
                                    window.location.replace("/praktikan/kelompok");
                                });
                            } else {
                                Swal.fire({
                                    title: json.title_alert_failed,
                                    text: data.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: json.btn_alert_ok,
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    }
                                });
                            }
                        }
                    });
                }
            })
        });

        return false;
    });
})
