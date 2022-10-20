$(document).ready(function() {
    "use strict";
    
    var tahun = $('#tahun_selected').val();
    var idhibah = $('#hibah_id_selected').val();
    
    if(idhibah != "" || idhibah != undefined ){
        $('#filter_tahun').show();
        $('#filterHibahPelaksanaan').val(tahun);
        $('#filter_hibah').show();
        $('#filterHibahOption').change();
    } else {
        $('#filter_tahun').hide();
        $('#filter_hibah').hide();
    }

    $('.col-jenis_media_massa').show();
    $('.col-file_media').show();
    $('.col-nama-unit-kerja').hide();
    $('.col-no_sertifikat').hide();
    $('.col-file_sertifikat').hide();

    function get_fakultas(){
        var fklts = $("#fakultas_id").val();

        if(fklts != '' || fklts != undefined){
            $('.col-fakultas').hide();
        } else {
            $('.col-fakultas').show();
        }
    }

    get_fakultas();

    $(document).on('change', '#jenis_media', function() {
        
        var jenis_media = $('#jenis_media').val();
        if(jenis_media == "Video"){
            $('.col-jenis_media_massa').hide();
            $('.col-file_media').hide();
        } else {
            $('.col-jenis_media_massa').show();
            $('.col-file_media').show();
        }
    });
    
    $(document).on('change', '#jenis_produk', function() {
        
        var jenis_produk = $('#jenis_produk').val();
        if(jenis_produk == "Terstandarisasi"){
            $('.col-no_standarisasi').show();
            $('.col-file_standarisasi').show();
            $('.col-no_sertifikat').hide();
            $('.col-file_sertifikat').hide();
        } else {
            $('.col-no_standarisasi').hide();
            $('.col-file_standarisasi').hide();
            $('.col-no_sertifikat').show();
            $('.col-file_sertifikat').show();
        }
    });

    $(document).on('change', '#jenis_unit_kerja', function() {
        
        var jenis_unit_kerja = $('#jenis_unit_kerja').val();
        var fakultas = $("#fakultas_id").val();

        if(jenis_unit_kerja == "Fakultas"){
            if(fakultas != "" || fakultas != undefined){
                $('.col-fakultas').hide();
            } else {
                $('.col-fakultas').show();
            }
            $('.col-nama-unit-kerja').hide();
        } else {
            $('.col-fakultas').hide();
            $('.col-nama-unit-kerja').show();
        }
    });
    /** Constant div card */
    const DIV_CARD = 'div.card';

    setTimeout(function() {
        $('.page-loader-wrapper').fadeOut();
    }, 50);
    /** Initialize tooltips */
    $('[data-toggle="tooltip"]').tooltip();

    /** Initialize popovers */
    $('[data-toggle="popover"]').popover({
        html: true
    });
    /** Function for remove card */
    $('[data-toggle="card-remove"]').on('click', function(e) {
        var $card = $(this).closest(DIV_CARD);
        $card.remove();
        e.preventDefault();
        return false;
    });
    /** Function for collapse card */
    $('[data-toggle="card-collapse"]').on('click', function(e) {
        var $card = $(this).closest(DIV_CARD);

        $card.toggleClass('card-collapsed');
        e.preventDefault();
        return false;
    });
    /** Function for fullscreen card */
    $('[data-toggle="card-fullscreen"]').on('click', function(e) {
        var $card = $(this).closest(DIV_CARD);

        $card.toggleClass('card-fullscreen').removeClass('card-collapsed');
        e.preventDefault();
        return false;
    });
    /**  */
    if ($('[data-sparkline]').length) {
        var generateSparkline = function($elem, data, params) {
            $elem.sparkline(data, {
                type: $elem.attr('data-sparkline-type'),
                height: '100%',
                barColor: params.color,
                lineColor: params.color,
                fillColor: 'transparent',
                spotColor: params.color,
                spotRadius: 0,
                lineWidth: 2,
                highlightColor: hexToRgba(params.color, .6),
                highlightLineColor: '#666',
                defaultPixelsPerValue: 5
            });
        };

        require(['sparkline'], function() {
            $('[data-sparkline]').each(function() {
                var $chart = $(this);

                generateSparkline($chart, JSON.parse($chart.attr('data-sparkline')), {
                    color: $chart.attr('data-sparkline-color')
                });
            });
        });
    }
    /**  */
    if ($('.chart-circle').length) {
        $('.chart-circle').each(function() {
            var $this = $(this);

            $this.circleProgress({
                fill: {
                    color: 'indigo'
                },
                size: $this.height(),
                startAngle: -Math.PI / 4 * 2,
                emptyFill: '#F4F4F4',
                lineCap: 'round'
            });
        });
    }
    // (Optional) Active an item if it has the class "is-active"	
    $(".accordion2 > .accordion-item.is-active").children(".accordion-panel").slideDown();

    $(".accordion2 > .accordion-item").on('click', function() {
        // Cancel the siblings
        $(this).siblings(".accordion-item").removeClass("is-active").children(".accordion-panel").slideUp();
        // Toggle the item
        $(this).toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
    });
    // block-header bar chart js
    $('.bh_income').sparkline('html', {
        type: 'bar',
        height: '30px',
        barColor: '#1A5089',
        barWidth: 5,
    });
    $('.bh_traffic').sparkline('html', {
        type: 'bar',
        height: '30px',
        barColor: '#E21E32',
        barWidth: 5,
    });

    function get_all_hibah(){
        var id = $('#filterHibahPelaksanaan').val();
        var sourcedata = $('#source_data').val();
        var jenisluaran = $('#jenis_luaran').val();

        if(sourcedata != undefined && jenisluaran != undefined){
            var url = "/pelaksanaan_kegiatan/catatan_harian/gethibah/" + id+"/"+jenisluaran+"/"+sourcedata;
        } else {
            var url = "/pelaksanaan_kegiatan/catatan_harian/gethibah/" + id;
        }

        var is_html = "";
        var my_html = "";
        $("#filter_hibah").hide();
        $("#catatan_harian").hide();
        $("#laporan_jurnal").hide();
        $("#laporan_pemakalah").hide();
        $("#laporan_luaranLain").hide();
        $("#abdimas").hide();
        $('#filter_jenis_review').hide();

        if(id != ""){
            var idhibah = $('#hibah_id_selected').val();
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if(data.status == "success" && data.hibah.length > 0 ){
                        is_html += '<option value="">-- Pilih Hibah --</option>';
                        data.hibah.forEach(element => {
 
                            var hibah_id = element.hibah_id;
                            var prop_id = element.proposal_id;
                            var hibah_code = element.hibah_code;
                            var jenis_hibah = element.jenis_hibah;
                            var jenis_program = element.jenis_program;
                            var penyelenggara = element.hibah_untuk == 'Umum' ? 'LPPM' : element.nama_fakultas;

                            is_html += '<option value="'+ hibah_id+'|'+prop_id+'" '+(idhibah == hibah_id ? 'selected' : '')+'>'+ penyelenggara +' - '+ jenis_hibah +' - '+ jenis_program +'</option>';
                        });

                        $("#filterHibahOption").html(is_html);
                        $("#filter_hibah").show();
                        get_hibah_selected();

                    } else {
                        is_html = '<option value="">Tidak ada hibah!</option>';

                        $("#filterHibahOption").html(is_html);
                        $("#filter_hibah").show();

                        tableCatatanHarian.ajax.url( '/pelaksanaan_kegiatan/catatan_harian/getall' ).load();
                        tableLaporanJurnal.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getalljurnal' ).load();
                        tableLaporanPemakalah.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallpemakalah' ).load();
                        tableLaporanluaranLainnya.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallluaranlain' ).load();
                        tableLuaranPoster.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallposter' ).load();
                        tableLaporanAkhir.ajax.url( '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir' ).load();
                        
                        my_html = "<tr><td colspan='4' align='center'>No data available in table</td></tr>";

                        $("#tableHibahPerDosen").html(my_html);
                    }
                },
            });
        } else {
           $("#filter_hibah").hide();

           my_html = "<tr><td colspan='4' align='center'>No data available in table</td></tr>";

            $("#tableHibahPerDosen").html(my_html);
        }
    }

    get_all_hibah();

    $("#filterHibahPelaksanaan").change(function(){
        $("#filterHibahOption").empty();
        get_all_hibah();
    });

    function get_hibah_selected() {
        var id = $('#filterHibahOption option:selected').val();
        var url = "/pelaksanaan_kegiatan/catatan_harian/getsinglehibah/" + id;
        var my_html = "";

        if(id != ""){
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if(data.status == "success" && data.hibah.length > 0 ){

                        my_html += "<tr>";

                        var penyelenggara = data.hibah[0].hibah_untuk == 'Umum' ? 'LPPM' : data.hibah[0].nama_fakultas;
                        var jenis_hibah = data.hibah[0].jenis_hibah;
                        var jenis_program = data.hibah[0].jenis_program;
                        var start_date = data.hibah[0].start_date;
                        var end_date = data.hibah[0].end_date;

                        my_html += "<td>" + penyelenggara + "</td>";
                        my_html += "<td>" + start_date +" s.d "+ end_date + "</td>";
                        my_html += "<td>" + jenis_hibah + "</td>";
                        my_html += "<td>" + jenis_program + "</td>";

                        my_html += "</tr>";

                        $("#tableHibahPerDosen").html(my_html);
                        $("#catatan_harian").show();
                        $("#laporan_jurnal").show();
                        $("#laporan_pemakalah").show();
                        $("#laporan_luaranLain").show();
                        if(jenis_hibah != 'Penelitian')
                            $("#abdimas").show();

                        var getUrl = window.location;
                        var baseUrl = getUrl.protocol + "//" + getUrl.host;
                        var val_catatan = "pelaksanaan_kegiatan/catatan_harian/add/";
                        var val_jurnal = "pelaksanaan_kegiatan/laporan_luaran/add_jurnal/";
                        var val_pemakalah = "pelaksanaan_kegiatan/laporan_luaran/add_pemakalah/";
                        var val_luaranLain = "pelaksanaan_kegiatan/laporan_luaran/add_luaran_lain/";
                        var baseUrlCatatanHarian = baseUrl + "/" + val_catatan+data.hibah[0].hibah_id+"/"+data.hibah[0].proposal_id;
                        var baseUrlFixJurnal = baseUrl + "/" + val_jurnal+data.hibah[0].hibah_id+"/"+data.hibah[0].proposal_id;
                        var baseUrlFixPemakalah = baseUrl + "/" + val_pemakalah+data.hibah[0].hibah_id+"/"+data.hibah[0].proposal_id;
                        var baseUrlFixLuaranLain = baseUrl + "/" + val_luaranLain+data.hibah[0].hibah_id+"/"+data.hibah[0].proposal_id;
                        var baseUrlFixInsentifReviewer = baseUrl + "/" +'insentif/reviewer/get/'+data.hibah[0].hibah_id;


                        $("#catatan_harian").attr('onclick',"openForm('"+baseUrlCatatanHarian+"')");
                        $('#laporan_jurnal').attr('onclick',"openForm('"+baseUrlFixJurnal+"')");
                        $('#laporan_pemakalah').attr('onclick',"openForm('"+baseUrlFixPemakalah+"')");
                        $('#laporan_luaranLain').attr('onclick',"openForm('"+baseUrlFixLuaranLain+"')");

                    } else {
                        my_html = "<tr><td colspan='4' align='center'>No data available in table</td></tr>";

                        $("#tableHibahPerDosen").html(my_html);
                    }
                },
            });
        }  else {
            tableCatatanHarian.ajax.url( '/pelaksanaan_kegiatan/catatan_harian/getall' ).load();
            tableLaporanJurnal.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getalljurnal' ).load();
            tableLaporanPemakalah.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallpemakalah' ).load();
            tableLaporanluaranLainnya.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallluaranlain' ).load();
            tableLuaranPoster.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallposter' ).load();
            tableLaporanAkhir.ajax.url( '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir' ).load();

            my_html = "<tr><td colspan='4' align='center'>No data available in table</td></tr>";

            $("#tableHibahPerDosen").html(my_html);
        }
    }

    get_hibah_selected();

    $("#filterHibahOption").change(function(){
        get_hibah_selected();
    });

    var tableCatatanHarian = $('#tableCatatanHarian').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pelaksanaan_kegiatan/catatan_harian/getall',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'hibah_id', name: 'hibah_id', orderable: false, searchable: false, visible: false },
            {
                data: 'uraian_catatan',
                name: 'uraian_catatan',
                render: function ( data, type, row ) {
                    return stripHtml(data);
                },
            },
            {   
                data: 'group_berkas_catatan_harian', 
                name: 'group_berkas_catatan_harian',
                render: function(data, type, row) {
                    var str = "";
                    if(row.group_berkas_catatan_harian!=null){
                        var newdata = row.group_berkas_catatan_harian.split(" | ");
                        newdata.forEach(element => {
                            var getUrl = window.location;
                            var baseUrl = getUrl.protocol + "//" + getUrl.host;
                            var val = "upload/catatan_harian/" + element;
                            var baseUrlImg = baseUrl + "/" + val;
                            str += element + '<br><a href="'+baseUrlImg+'" target="_blank">Download</a><br>';
                        });
                    }else{
                        str = '-';
                    }

                    return str;
                }
            },
            { data: 'persentase_kegiatan', name: 'persentase_kegiatan' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });
   
    var tableLaporanJurnal = $('#tableLaporanJurnal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pelaksanaan_kegiatan/laporan_luaran/getalljurnal',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'publikasi_jurnal_id', name: 'publikasi_jurnal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'nama_jurnal',
                render: function(data, type, row) {
                    var str = '<b>Nama Jurnal</b> : '+row.nama_jurnal + '<br>';
                    str += '<b>Tingkat</b> : ' + row.tingkat_jurnal +'<br>';
                    str += '<b>ISSN</b> : '+ row.issn +'<br>';
                    str += '<b>Impact Factor</b> : '+row.impact_factor;

                    return str;
                }
            },
            {   
                data: 'judul', 
                render: function(data, type, row) {
                    var str = '<b>Judul Publikasi</b> : '+row.judul + '<br>';
                    str += '<b>URL</b> : '+row.url + '<br>';
                    str += '<b>Status</b> : '+row.status_naskah + '<br>';

                    return str;
                }
            },
            {   
                data: 'berkas_publikasi_jurnal', 
                name: 'berkas_publikasi_jurnal',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/publikasi_ilmiah/" +row.berkas_publikasi_jurnal;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_publikasi_jurnal != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });
   
    var tableLaporanPemakalah = $('#tableLaporanPemakalah').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pelaksanaan_kegiatan/laporan_luaran/getallpemakalah',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pemakalah_id', name: 'pemakalah_id', orderable: false, searchable: false, visible: false },
            {
                data: 'nama_forum',
                render: function(data, type, row) {
                    var str = '<b>Nama Forum</b> : '+row.nama_forum + '<br>';
                    str += '<b>Tingkat</b> : ' + row.jenis_forum +'<br>';
                    str += '<b>Penyelenggara</b> : ' + row.institusi_penyelenggara +'<br>';
                    str += '<b>Tempat</b> : '+row.tempat_pelaksanaan+'<br>';
                    str += '<b>Tanggal</b> : '+row.tanggal_mulai+' s.d '+row.tanggal_akhir;

                    return str;
                }
            },
            {   
                data: 'judul_makalah', 
                render: function(data, type, row) {
                    var str = '<b>Judul Makalah</b> : '+row.judul_makalah + '<br>';
                    str += '<b>Status</b> : '+row.status_pemakalah + '<br>';

                    return str;
                }
            },
            {   
                data: 'berkas_pemakalah', 
                name: 'berkas_pemakalah',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/pemakalah_forum_ilmiah/" +row.berkas_pemakalah;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_pemakalah != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    var tableLuaranPoster = $('#tableLuaranPoster').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pelaksanaan_kegiatan/laporan_luaran/getallposter',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            { data: 'judul_proposal', name: 'judul_proposal' },
            {
                data: 'judul_poster',
                render: function(data, type, row) {
                    var str = row.judul_poster!=null ? row.judul_poster:'-';

                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });
    
    var tableLaporanluaranLainnya = $('#tableLaporanluaranLainnya').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pelaksanaan_kegiatan/laporan_luaran/getallluaranlain',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'id', name: 'id', orderable: false, searchable: false, visible: false },
            { data: 'flag', name: 'flag'},
            { data: 'judul', name: 'judul' },
            { data: 'jenis', name: 'jenis' },
            {
                data: 'berkas',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;

                    if(row.flag == "Luaran Lainnya"){
                        var val = "upload/luaran_lainnya/" +row.berkas;
                    } else if (row.flag == "HKI"){
                        var val = "upload/hki/" +row.berkas;
                    } else {
                        var val = "upload/buku_ajar/" +row.berkas;
                    }

                    var baseUrlImg = baseUrl + "/" + val;

                    
                    if(row.berkas !== null){
                        var file = '<a href="'+baseUrlImg+'" title="Download Dokumen" target="_blank">Download</a>';
                    } else {
                        var file = '-';
                    }

                    var str = file;
                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    
    var tableLaporanAkhir = $('#tableLaporanAkhir').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = row.jenis_hibah+' - '+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'judul_proposal' },
            { 
                data: 'jumlah_pencairan_dana', 
                name: 'jumlah_pencairan_dana',
                render: function(data, type, row) {
                    var str = 'Rp '+formatMoney(row.jumlah_pencairan_dana);//+' - '+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                } 
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            }
        ]
    });

    $('#tableContact').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/umum/contact/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'contact_us_id', name: 'contact_us_id', orderable: false, searchable: false, visible: false },
            { data: 'contact_name', name: 'contact_name' },
            { data: 'contact_email', name: 'contact_email' },
            { data: 'message', name: 'message' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    $(document).on('change','#filterHibahOption', function(){
        var val=$(this).val().split('|');
        tableCatatanHarian.ajax.url( '/pelaksanaan_kegiatan/catatan_harian/getall/'+val[0]+'/'+val[1] ).load();
        tableLaporanJurnal.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getalljurnal/'+val[0]+'/'+val[1] ).load();
        tableLaporanPemakalah.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallpemakalah/'+val[0]+'/'+val[1]).load();
        tableLaporanluaranLainnya.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallluaranlain/'+val[0]+'/'+val[1]).load();
        tableLuaranPoster.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallposter/'+val[0]+'/'+val[1] ).load();
        tableLaporanAkhir.ajax.url( '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir/'+val[0]+'/'+val[1] ).load();


        if($(this).val() == ""){
            $("#catatan_harian").hide();
            $("#laporan_jurnal").hide();
            $("#laporan_pemakalah").hide();
            $("#laporan_luaranLain").hide();
            $('#abdimas').hide();
        }

        if($('#filter_jenis_review').length != 0){
            $('#filter_jenis_review').show();
        }
    });

    $(document).on('change','#filterHibahPelaksanaan', function(){
        if($(this).val() == ""){
            tableCatatanHarian.ajax.url( '/pelaksanaan_kegiatan/catatan_harian/getall' ).load();
            tableLaporanJurnal.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getalljurnal' ).load();
            tableLaporanPemakalah.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallpemakalah' ).load();
            tableLaporanluaranLainnya.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallluaranlain' ).load();
            tableLuaranPoster.ajax.url( '/pelaksanaan_kegiatan/laporan_luaran/getallposter' ).load();
            tableLaporanAkhir.ajax.url( '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir' ).load();
        }
    });
});

// table-filter js
$(document).ready(function() {
    $('.star').on('click', function() {
        $(this).toggleClass('star-checked');
    });
    $('.ckbox label').on('click', function() {
        $(this).parents('tr').toggleClass('selected');
    });
    $('.btn-filter').on('click', function() {
        var $target = $(this).data('target');
        if ($target != 'all') {
            $('.table tr').css('display', 'none');
            $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
        } else {
            $('.table tr').css('display', 'none').fadeIn('slow');
        }
    });
});

// Sidebar Setting
$(document).ready(function() {
    "use strict";
    // sidebar navigation
    $('.sidebar-nav').metisMenu();

    // Menu toggle
    $('.menu_toggle').on('click', function() {
        $('body').toggleClass('offcanvas-active');
    });
    // Chat sidebar toggle
    $('.chat_list_btn').on('click', function() {
        $('.chat_list').toggleClass('open');
    });
    // User Menu
    $('.menu_option').on('click', function() {
        $('.metismenu').toggleClass('grid');
        $('.menu_option').toggleClass('active');
    });
    // User Menu
    $('.user_btn').on('click', function() {
        $('.user_div').toggleClass('open');
    });
    // right side bar
    $('a.settingbar').on('click', function() {
        $('.right_sidebar').toggleClass('open');
    });
    // theme option
    $('a.theme_btn').on('click', function() {
        $('.theme_div').toggleClass('open');
    });
    $('.page').on('click', function() {
        $('.theme_div, .right_sidebar').removeClass('open');
        $('.user_div').removeClass('open');
    });
    // Theme Light Dark
    $('.theme_switch').on('click', function() {
        $('body').toggleClass('theme-dark');
    });
});

// Font Setting and icon
$(document).ready(function() {
    "use strict";
    var setting = $('#valuesettings').val();
    var userid = $('#valueid').val();
    setting = JSON.parse(setting);
    $('.metismenu .has-arrow').addClass('arrow-' + setting[1]);
    // Font icon Setting 
    $('.arrow_option input:radio').click(function() {
        var others = $("[name='" + this.name + "']").map(function() {
            return this.value
        }).get().join(" ")
        console.log(others)
        var values = this.value;
        if (values.includes('-a')) {
            setting[1] = 'a';
        } else if (values.includes('-b')) {
            setting[1] = 'b';
        } else if (values.includes('-c')) {
            setting[1] = 'c';
        }
        var imp = setting.join('|');

        //update by ajax
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/authentication/updatesetting',
            data: { user_id: userid, settings: imp },
            success: function(data) {
                $('.metismenu .has-arrow').removeClass(others).addClass(values)
            }
        });
    });

    $('.metismenu li .collapse a').addClass('list-' + setting[2])
    $('.list_option input:radio').click(function() {
        var others = $("[name='" + this.name + "']").map(function() {
            return this.value
        }).get().join(" ")
        console.log(others)
        var values = this.value;
        if (values.includes('-a')) {
            setting[2] = 'a';
        } else if (values.includes('-b')) {
            setting[2] = 'b';
        } else if (values.includes('-c')) {
            setting[2] = 'c';
        }
        var imp = setting.join('|');

        //update by ajax
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/authentication/updatesetting',
            data: { user_id: userid, settings: imp },
            success: function(data) {
                $('.metismenu li .collapse a').removeClass(others).addClass(values)
            }
        });
    });
    // Font Setting 
    $('body').addClass('font-' + setting[0])
    $('.font_setting input:radio').click(function() {
        var others = $("[name='" + this.name + "']").map(function() {
            console.log(this.value)
            return this.value
        }).get().join(" ")
        console.log(others)
        var values = this.value;
        if (values.includes('montserrat')) {
            setting[0] = 'montserrat';
        } else if (values.includes('opensans')) {
            setting[0] = 'opensans';
        } else if (values.includes('roboto')) {
            setting[0] = 'roboto';
        }
        var imp = setting.join('|');

        //update by ajax
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/authentication/updatesetting',
            data: { user_id: userid, settings: imp },
            success: function(data) {
                $('body').removeClass(others).addClass(values)
            }
        });
    });
});

// Switch Setting
$(document).ready(function() {
    "use strict";
    var setting = $('#valuesettings').val();
    var userid = $('#valueid').val();
    setting = JSON.parse(setting);

    if (setting[3] == '1') {
        $('body').addClass('dark-mode');
        $(".setting_switch .btn-sidebar").prop('disabled', true);
        $(".setting_switch .btn-min_sidebar").prop('disabled', true);
        $(".setting_switch .btn-pageheader").prop('disabled', true);
    } else {
        $('body').removeClass('dark-mode');
        $(".setting_switch .btn-sidebar").prop('disabled', false);
        $(".setting_switch .btn-min_sidebar").prop('disabled', false);
        $(".setting_switch .btn-pageheader").prop('disabled', false);
    }
    // Full Dark mode
    $(".setting_switch .btn-darkmode").on('change', function() {
        if (this.checked) {
            setting[3] = '1'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('body').addClass('dark-mode');
                    $(".setting_switch .btn-sidebar").prop('disabled', true);
                    $(".setting_switch .btn-min_sidebar").prop('disabled', true);
                    $(".setting_switch .btn-pageheader").prop('disabled', true);
                }
            });
        } else {
            setting[3] = '0'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('body').removeClass('dark-mode');
                    $(".setting_switch .btn-sidebar").prop('disabled', false);
                    $(".setting_switch .btn-min_sidebar").prop('disabled', false);
                    $(".setting_switch .btn-pageheader").prop('disabled', false);
                }
            });
        }
    });

    // Top bar sticky
    if (setting[4] == '1') {
        $('#page_top').addClass('sticky-top');
    } else {
        $('#page_top').removeClass('sticky-top');
    }
    $(".setting_switch .btn-fixnavbar").on('change', function() {
        if (this.checked) {
            setting[4] = '1'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('#page_top').addClass('sticky-top');
                }
            });
        } else {
            setting[4] = '0'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('#page_top').removeClass('sticky-top');
                }
            });
        }
    });

    // icon-color
    // $(".setting_switch .btn-iconcolor").on('change',function() {
    // 	if(this.checked) {
    // 		$('body').addClass('iconcolor');
    // 	}else{
    // 		$('body').removeClass('iconcolor');
    // 	}
    // });    
    // // Gradient Color
    // $(".setting_switch .btn-gradient").on('change',function() {
    // 	if(this.checked) {
    // 		$('body').addClass('gradient');
    // 	}else{
    // 		$('body').removeClass('gradient');
    // 	}
    // });
    // Dark Sidebar
    if (setting[7] == '1') {
        $('body').addClass('sidebar_dark');
    } else {
        $('body').removeClass('sidebar_dark');
    }
    $(".setting_switch .btn-sidebar").on('change', function() {
        if (this.checked) {
            setting[7] = '1'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('body').addClass('sidebar_dark');
                }
            });
        } else {
            setting[7] = '0'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('body').removeClass('sidebar_dark');
                }
            });
        }
    });

    if (setting[6] == '1') {
        $('#header_top').addClass('dark');
    } else {
        $('#header_top').removeClass('dark');
    }
    $(".setting_switch .btn-min_sidebar").on('change', function() {
        if (this.checked) {
            setting[6] = '1'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('#header_top').addClass('dark');
                }
            });
        } else {
            setting[6] = '0'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('#header_top').removeClass('dark');
                }
            });
        }
    });
    // Dark Sidebar
    if (setting[5] == '1') {
        $('#page_top').addClass('top_dark');
    } else {
        $('#page_top').removeClass('top_dark');
    }
    $(".setting_switch .btn-pageheader").on('change', function() {
        if (this.checked) {
            setting[5] = '1'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('#page_top').addClass('top_dark');
                }
            });
        } else {
            setting[5] = '0'
            var imp = setting.join('|');

            //update by ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/authentication/updatesetting',
                data: { user_id: userid, settings: imp },
                success: function(data) {
                    $('#page_top').removeClass('top_dark');
                }
            });
        }
    });

    // Box Shadow
    $(".setting_switch .btn-boxshadow").on('change', function() {
        if (this.checked) {
            $('.card, .btn, .progress').addClass('box_shadow');
        } else {
            $('.card, .btn, .progress').removeClass('box_shadow');
        }
    });

    // RTL Support
    $(".setting_switch .btn-rtl").on('change', function() {
        if (this.checked) {
            $('body').addClass('rtl');
        } else {
            $('body').removeClass('rtl');
        }
    });

    // RTL Support
    $(".setting_switch .btn-boxlayout").on('change', function() {
        if (this.checked) {
            $('body').addClass('boxlayout');
        } else {
            $('body').removeClass('boxlayout');
        }
    });
});

$(document).on('click', '.bataltxtproposal', function(){    
    $('#modalbatalproposal').modal('show');
    $('#txtbatal').empty();
    var title = $(this).attr('data-title');
    $('#txtbatal').html(title);

    return false;
});

$(document).on('click', '.revisiinsentif', function(){    
    $('#modalrevisi').modal('show');
    $('#txtrevisi').empty();
    var title = $(this).attr('data-title');
    $('#txtrevisi').html(title);

    return false;
});

//reset password
$(document).on('click', '#resetpass', function(){
    var id = $(this).attr('data-id');

    var url = "/home/reset-password/" + id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Password akan di-reset dan tidak dapat dipulihkan!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Reset!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Success!", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    });
});

//onchange untuk syarat hibah
$(document).on('change', '#syarat_hibah_1', function() {
    $('#syarat_hibah').modal('show');
    $('.syarat_pangkat').prop('disabled', true);
    $('#showException').hide();
    $('#showtombolsyarat').show();
});

$(document).on('change', '#syarat_hibah_2', function() {
    $('#syarat_hibah').find('form')[0].reset();
    $('#syarat_hibah').modal('hide');
    // $('.selectpicker').prop('disabled', true);
    $('#showtombolsyarat').hide();
    $('#exception_hibah_hidden').val('[]');
    $('#syarat_hibah_hidden').val('[]');
});

$(document).on('click', '#btnapprovefinalf', function(){
    var selected = JSON.parse(window.localStorage['selected']);

    var data_id = JSON.parse($(this).attr("data-id"));
    var arr_id = [];

    for(var i=0;i<data_id.length;i++){
        arr_id.push(data_id[i].proposal_id);
    }

    var notWin = []; 
    notWin = arr_id.filter( function( el ) {
        return selected.indexOf( el ) < 0;
    });

    if(selected.length <= 0){
        swal("Warning", "Pilih data terlebih dahulu", "warning");
        return;
    }else{
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin menyetujui data terpilih?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Ya, Setujui",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: { 'pemenang': JSON.stringify(selected), 'tidak_menang': JSON.stringify(notWin) },
                    url: '/proposalhibah/penentuanpemenangfakultas',
                    success: function(data) {
                        if (data.status) {
                            swal({ title: "Sukses", text: "Pemenang berhasil ditetapkan", type: "success" },
                                function() {
                                    location.reload();
                                }
                            );
                        } else {
                            swal("Warning", data.message, "warning")
                        }
                    }
                })
            }
        });
    }

    return false;
});

$(document).on("click", "#modalFinalisasi", function() {
    var selected = JSON.parse(window.localStorage['selected']);
    // if(a.length == 0){
    //     swal("Warning", "Pilih data terlebih dahulu", "warning");
    //     return;
    // }else{
    if(selected.length <= 0){
        swal("Warning", "Pilih data terlebih dahulu", "warning");
        return;
    }else{
        $('#finalisasi').modal('show');
        $(".modal-body #selectedData").val($(this).attr("data-id"));
    }
    
});

$(document).on('click', '#btnapprovefinal', function(){
    var selected = JSON.parse(window.localStorage['selected']);

    var data_id = JSON.parse($("#selectedData").val())
    var arr_id = [];
    
    for(var i=0;i<data_id.length;i++){
        arr_id.push(data_id[i].proposal_id);
    }

    var notWin = []; 
    notWin = arr_id.filter( function( el ) {
        return selected.indexOf( el ) < 0;
    });

    if(selected.length <= 0){
        swal("Warning", "Pilih data terlebih dahulu", "warning");
        return;
    }else{
        var sendData = {};
        sendData.pemenang = JSON.stringify(selected);
        sendData.tidak_menang = JSON.stringify(notWin);
        sendData.catatan_harian_start = $('#tanggal_catatan_start').val();
        sendData.catatan_harian_end = $('#tanggal_catatan_end').val();
        sendData.laporan_luaran_start = $('#tanggal_luaran_start').val();
        sendData.laporan_luaran_end = $('#tanggal_luaran_end').val();
        sendData.laporan_akhir_start = $('#tanggal_laporan_start').val();
        sendData.laporan_akhir_end = $('#tanggal_laporan_end').val();
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin menyetujui data terpilih?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Ya, Setujui",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: sendData,
                    url: '/proposalhibah/penentuanpemenanglppm',
                    success: function(data) {
                        if (data.status) {
                            swal({ title: "Sukses", text: "Pemenang berhasil ditetapkan", type: "success" },
                                function() {
                                    location.reload();
                                }
                            );
                        } else {
                            swal("Warning", data.message, "warning")
                        }
                    }
                })
            }
        });
    }

    return false;
});

$(document).on('click', '.cbpemenang', function(){
    var data = JSON.parse(window.localStorage['selected']);

    if ($(this).is(':checked'))
        data.push(parseInt($(this).val()));
    else
        data.splice(data.indexOf(parseInt($(this).val())));
    window.localStorage['selected'] = JSON.stringify(data);
    // console.log(window.localStorage['selected']);
});

$(document).on('click', '#btnsimpansyarat', function() {
    var form_data = $("#form_syarat").serializeArray();
    var pangkat = form_data.filter(function(e) {
        return e.name == 'syarat_pangkat';
    });

    console.log(form_data);
    if (form_data.length == 0) {
        swal("Warning", "Please select minimum one item", "warning");
        return;
    }
    var json = [];
    for (var i = 0; i < form_data.length; i++) {
        if (form_data[i].value != 'Minimal Pangkat' && form_data[i].name != 'syarat_pangkat' && form_data[i].name != 'selectException')
            json.push({ 'jenis_syarat': form_data[i].value, 'minimal_pangkat': null });
    }
    if (pangkat.length > 0) {
        json.push({ 'jenis_syarat': 'Minimal Pangkat', 'minimal_pangkat': pangkat[0].value });
    }

    $('#syarat_hibah_hidden').val(JSON.stringify(json));
    $('#exception_hibah_hidden').val(JSON.stringify($('#selectException').val()));

    $('#syarat_hibah').modal('hide');
    // console.log(json);

    return false;
});


$(document).on('click', '#btnbatalsyarat', function() {
    $("#form_syarat")[0].reset();

    $('#syarat_hibah_2').prop('checked', true);
    $('#showtombolsyarat').hide();

    // $('#selectException').prop('disabled', true);
    $("#selectException").val([]);
    $("#selectException").selectpicker("refresh");

    $('#syarat_hibah').modal('hide');
    return false;
});

$(document).on("change", "#selectException", function() {
    $("#menu").empty();
    var options = $(this).find("option:selected");
    var selected = [];

    $(options).each(function() {
        selected.push($(this).text());
        $('#menu').append('<li style="border: 1px solid;padding:5px;" class="mr-10 mb-10">' + $(this).text() + '</li>');
        // or $(this).val() for 'id'
    });
});

$(document).on('click', '#btnassignment', function() {
    var nilai = $('#selectReviewer').val();
    var x = [];
    // x = JSON.parse(window.localStorage['id']);
    x = nilai;
    // for (var i = 0; i < nilai.length; i++) {
    //     if(!x.includes(nilai[i]))
    //         x.push(nilai[i]);
    // }
    window.localStorage['id'] = JSON.stringify(x);
    if (x.length == 0) {
        swal("Warning", "Anda belum memilih reviewer", 'warning');
    } else {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin menugaskan reviewer terpilih?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Ya, Tugaskan",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm) {
                var getUrl = window.location;
                var baseUrl = getUrl.protocol + "//" + getUrl.host;
                var val = "assets/images/loading.gif";
                var baseUrlImg = baseUrl + "/" + val;
    
                window.swal({
                    title: "Please wait",
                    text: "Mohon tunggu...",
                    imageUrl: baseUrlImg,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: { 'data': x, 'hibah_id': $('#hId').val(), 'proposal_id': $('#pId').val() },
                    url: '/proposalhibah/assignreviewer',
                    success: function(data) {
                        if (data.status) {
                            swal({ title: "Sukses", text: "Reviewer telah ditugaskan", type: "success" },
                                function() {
                                    location.reload();
                                }
                            );
                        } else {
                            swal("Warning", data.message, "warning")
                        }
                    }
                })
            }
        });
    }
});

$(document).on('click', '#btnassignment2', function() {
    var nilai = $('#selectReviewer2').val();
    var x = [];
    // x = JSON.parse(window.localStorage['id2']);
    x = nilai;
    // for (var i = 0; i < nilai.length; i++) {
    //     if(!x.includes(nilai[i]))
    //         x.push(nilai[i]);
    // }
    window.localStorage['id2'] = JSON.stringify(x);
    if (x.length == 0) {
        swal("Warning", "Anda belum memilih reviewer", 'warning');
    } else {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin menugaskan reviewer terpilih?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Ya, Tugaskan",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm) {
                var getUrl = window.location;
                var baseUrl = getUrl.protocol + "//" + getUrl.host;
                var val = "assets/images/loading.gif";
                var baseUrlImg = baseUrl + "/" + val;
    
                window.swal({
                    title: "Please wait",
                    text: "Mohon tunggu...",
                    imageUrl: baseUrlImg,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: { 'data': x, 'hibah_id': $('#hId').val(), 'proposal_id': $('#pId').val(), 'laporan_akhir_id': $('#lId').val() },
                    url: '/pelaksanaan_kegiatan/laporan_akhir/assignreviewer',
                    success: function(data) {
                        if (data.status) {
                            swal({ title: "Sukses", text: "Reviewer telah ditugaskan", type: "success" },
                                function() {
                                    location.reload();
                                }
                            );
                        } else {
                            swal("Warning", data.message, "warning")
                        }
                    }
                })
            }
        });
    }
});

$(document).on("change", "#selectReviewer", function() {
    $("#menu").empty();
    var options = $(this).find("option:selected");
    var selected = [];

    $(options).each(function() {
        selected.push($(this).text());
        $('#menu').append('<li style="border: 1px solid;padding:5px;" class="mr-10 mb-10">' + $(this).text() + '</li>');
        // or $(this).val() for 'id'
    });
});

$(document).on("click", "#uploadfinalreport", function() {
    // var a = JSON.parse(window.localStorage['id']); 
    // if(a.length == 0){
    //     swal("Warning", "Pilih data terlebih dahulu", "warning");
    //     return;
    // }else{
    $('#upload_laporan_akhir').modal('show');
    var data = $(this).data('id');
    var m = data.split('|');
    $(".modal-body #proposal_hidden").val(m[1]);
    $(".modal-body #hibah_hidden").val(m[0]);
    if(m[2] == 'Penelitian'){
        $('#changeurl').attr('href','/template/template_laporan_akhir_penelitian.docx');
    }else{
        $('#changeurl').attr('href','/template/template_laporan_akhir_pengmas.docx');
    }
});

$(document).on("click", "#uploadinsentifs", function() {
    $('#upload_insentif').modal('show');
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var data = $(this).data('id');
    $(".modal-body #pengajuan_insentif_hidden").val(data);
    $('#linkInsentif').attr('href', baseUrl+'/insentif/pengajuan/download/'+data);
    // $('#changeurl').attr('href','/template/template_laporan_akhir_penelitian.docx');
});

$(document).on("click", "#uploadsertifikathki", function() {
    $('#upload_sertifikat_hki').modal('show');
    var data = $(this).data('id');
    $(".modal-body #pengajuan_insentif_hki_hidden").val(data);
});

$(document).on("click", "#uploadposter", function() {
    // var a = JSON.parse(window.localStorage['id']); 
    // if(a.length == 0){
    //     swal("Warning", "Pilih data terlebih dahulu", "warning");
    //     return;
    // }else{
    $('#upload_poster').modal('show');
    var data = $(this).data('id');
    var m = data.split('|');
    $(".modal-body #proposal_hidden").val(m[1]);
    $(".modal-body #hibah_hidden").val(m[0]);
});

$(document).on("click", "#warningupload", function() {
    var data = $(this).data('id');
    var m = data.split('|');
    
    swal("Warning", "Anda belum bisa mengunggah laporan akhir karena masa unggah laporan akhir ditanggal "+formatDate(new Date(m[0]))+' dan '+formatDate(new Date(m[1])), "warning");
});

$(document).on("click", ".btnassign", function() {
    // var a = JSON.parse(window.localStorage['id']); 
    // if(a.length == 0){
    //     swal("Warning", "Pilih data terlebih dahulu", "warning");
    //     return;
    // }else{
    $('#assign_reviewer').modal('show');
    var data = $(this).data('id');
    var m = data.split('|');

    //clear before append
    $('#form_rvw1').html('');
    // $('#form_rvw2').html('');

    $(".modal-body #pId").val(m[1]);
    $(".modal-body #hId").val(m[2]);
    var options = [];
    m[0] = JSON.parse(m[0]);
    if (m[0].reviewer1.length == 0) {
        options.push('<h6>Tidak ada data yang sesuai Reviewer yang sesuai, silahkan pilih Reviewer di tab berikutnya</h6>')
    } else {
        $.each(m[0].reviewer1, function(index, option) {
            options.push('<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input rr1" name="reviewer[]" value="' + option.user_id + '"><span class="custom-control-label">&nbsp;' + option.nama_dosen + '</span></label>');
        });
    }
    $('#form_rvw1').append(options.join(''));

    options = [];
    $('.selectpicker').val('[]').selectpicker('refresh');
    $('#selectReviewer').empty();
    $('#menu').empty();
    if (m[0].reviewer2.length == 0) {
        options.push('<h5>Belum ada data</h5>');
    } else {
        $.each(m[0].reviewer2, function(index, option) {
            //     options.push('<option value="'+option.user_id+'">'+option.nama_dosen+'</option>');
            $('#selectReviewer').append($('<option>').val(option.user_id).text(option.nama_lengkap));
        });

        $('.selectpicker').selectpicker('refresh');
    }
});

$(document).on("click", ".btnassign2", function() {
    // var a = JSON.parse(window.localStorage['id']); 
    // if(a.length == 0){
    //     swal("Warning", "Pilih data terlebih dahulu", "warning");
    //     return;
    // }else{
    $('#assign_reviewer2').modal('show');
    var data = $(this).data('id');
    var m = data.split('|');

    //clear before append
    $('#form_rvw1').html('');
    // $('#form_rvw2').html('');

    $(".modal-body #pId").val(m[1]);
    $(".modal-body #hId").val(m[2]);
    $(".modal-body #lId").val(m[3]);
    var options = [];
    m[0] = JSON.parse(m[0]);

    options = [];
    $('.selectpicker').val('[]').selectpicker('refresh');
    $('#selectReviewer2').empty();
    $('#menu').empty();
    if (m[0].length == 0) {
        options.push('<h5>Belum ada data</h5>')
    } else {
        $.each(m[0], function(index, option) {
            $('#selectReviewer2').append($('<option>').val(option.user_id).text(option.nama_lengkap));
        });

        $('.selectpicker').selectpicker('refresh');
    }
});

$(document).on('click', '#btnapprovehibah', function() {
    var id = $(this).data('id');
    var url = '/hibah/penelitian/approve/' + id;
    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin menyetujui hibah ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Setujui",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;
            var val = "assets/images/loading.gif";
            var baseUrlImg = baseUrl + "/" + val;

            window.swal({
                title: "Please wait",
                text: "Mohon tunggu...",
                imageUrl: baseUrlImg,
                showConfirmButton: false,
                allowOutsideClick: false
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {
                        swal({ title: "Sukses", text: "Hibah sudah disetujui", type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "warning");
        }
    })
    return false;
});

$(document).on('click', '.btnapproveprop', function() {
    var id = $(this).data('id');
    var url = '/proposalhibah/approve/' + id;
    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin menyetujui proposal ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Setujui",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;
            var val = "assets/images/loading.gif";
            var baseUrlImg = baseUrl + "/" + val;

            window.swal({
                title: "Please wait",
                text: "Mohon tunggu...",
                imageUrl: baseUrlImg,
                showConfirmButton: false,
                allowOutsideClick: false
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Sukses", text: "Proposal sudah disetujui", type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "warning");
        }
    })
    return false;
});

$(document).on('click', '#btnapprovelaporanakhir', function() {
    var id = $(this).data('id');
    var url = '/pelaksanaan_kegiatan/laporan_akhir/approve/' + id;
    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin mengirim laporan ini ke Ketua LPPM?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Kirimkan",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;
            var val = "assets/images/loading.gif";
            var baseUrlImg = baseUrl + "/" + val;

            window.swal({
                title: "Please wait",
                text: "Mohon tunggu...",
                imageUrl: baseUrlImg,
                showConfirmButton: false,
                allowOutsideClick: false
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Sukses", text: "Laporan Akhir sudah diteruskan ke Ketua LPPM", type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        }
    })
    return false;
});

$(document).on('click', '#btnapprovepf', function() {
    var id = $(this).data('id');
    var url = '/home/approvepemenangfakultas/' + id;
    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin menyetujui proposal ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Setujui",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;
            var val = "assets/images/loading.gif";
            var baseUrlImg = baseUrl + "/" + val;

            window.swal({
                title: "Please wait",
                text: "Mohon tunggu...",
                imageUrl: baseUrlImg,
                showConfirmButton: false,
                allowOutsideClick: false
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Sukses", text: "Proposal sudah disetujui dan diteruskan ke Ketua LPPM", type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "warning");
        }
    })
    return false;
});

$(document).on('click', '.sremind', function(){
    $('#modalSendReminder').modal('show');
    $('#alasan').val('');
    var id = $(this).attr('data-id');
    $('#hibahId').val(id);

    return false;
});

$(document).on('click', '#btnrejecthibah', function() {
    var id = $(this).data('id');
    var url = '/hibah/penelitian/reject/' + id;
    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin membatalkan hibah ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Batalkan",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {
                        swal({ title: "Sukses", text: "Hibah sudah dibatalkan", type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "warning");
        }
    })
    return false;
});

$(document).on('click', '#cekStatusHKI', function(){
    $('#detailHki').modal({
        backdrop: 'static',
        keyboard: true, 
        show: true
    });

    $('#token').val('');
    $('#show').hide();

    return false
});

$(document).on('click', '#btnCekHki', function(){
    var token = $('#token').val();

    if(token != ''){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/insentif/pengajuan/getstatus/'+token,
            success: function(resp) {
                var data = resp.data;
                if(resp.status){
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;

                    if(data.status != 'Revisi'){
                        $('#show').show();
                        $('#show').empty();
                        $('#show2').hide();
                        $('#show2').empty();

                        var str = '<table style="width:100%">';
                        str += '<tr>'+
                                '<td>Status Pengajuan</td>'+
                                '<td>'+data.status+'</td>'+
                            '</tr>'; 
                        str += '<tr>'+
                                '<td>Nama Pemohon</td>'+
                                '<td>'+data.nama+'</td>'+
                            '</tr>'; 
                        str += '<tr>'+
                                '<td>No Telp / HP</td>'+
                                '<td>'+data.no_hp+'</td>'+
                            '</tr>';
                        str += '<tr>'+
                                '<td>Alamat</td>'+
                                '<td>'+data.alamat+'</td>'+
                            '</tr>';
                        str += '<tr>'+
                                '<td>Judul</td>'+
                                '<td>'+data.judul+'</td>'+
                            '</tr>';
                        str += '<tr>'+
                            '<td>Anggota</td>'+
                            '<td>'+
                                '<table class="table table-bordered">'+
                                '<tr>'+
                                    '<td><b>Nama</b></td>'+
                                    '<td><b>Alamat</b></td>'+
                                    '<td><b>No Telp / HP</b></td>'+
                                '</tr>';
                                for(var i=0;i<data.member.length;i++){
                                    str += '<tr>'+
                                        '<td>'+data.member[i].nama+'</td>'+
                                        '<td>'+data.member[i].alamat+'</td>'+
                                        '<td>'+data.member[i].no_hp+'</td>'+
                                    '</tr>';
                                }
                                str += '</table>'+
                            '</td>'+
                        '</tr>';
                        str += '<tr>'+
                                '<td>Tanggal Publikasi</td>'+
                                '<td>'+data.tanggal_publikasi+'</td>'+
                            '</tr>'; 
        
                        str += '<tr>'+
                                '<td>Nama Kota Publikasi</td>'+
                                '<td>'+data.nama_kota_publikasi+'</td>'+
                            '</tr>';
                        str += '<tr>'+
                                '<td>Resensi / Uraian</td>'+
                                '<td>'+data.resensi_uraian+'</td>'+
                            '</tr>';
                                            
                        str += '<tr>'+
                                '<td>Berkas KTP / NPWP</td>'+
                                '<td><a href="'+baseUrl+'/upload/berkas_ktp_npwp/'+data.berkas_ktp_npwp+'">Download</a></td>'+
                            '</tr>';
                        
                        str += '<tr>'+
                                '<td>Surat Pengalihan Hak Pemohon</td>'+
                                '<td><a href="'+baseUrl+'/upload/surat_pengalihan_hak_pemohon/'+data.surat_pengalihan_hak_pemohon+'">Download</a></td>'+
                            '</tr>';
        
                        str += '<tr>'+
                                '<td>Surat Pernyataan Pihak UMJ</td>'+
                                '<td><a href="'+baseUrl+'/upload/surat_pernyataan_pihak_umj/'+data.surat_pernyataan_pihak_umj+'</td>'+
                            '</tr>';
                        
                        str += '<tr>'+
                                '<td>Karya Cipta</td>'+
                                '<td><a href="'+baseUrl+'/upload/karya_cipta/'+data.karya_cipta+'">Download</a></td>'+
                            '</tr>';
                        
                        str += '<tr>'+
                            '<td>Bukti Transfer</td>'+
                            '<td><a href="'+baseUrl+'/upload/bukti_transfer/'+data.bukti_transfer+'">Download</a></td>'+
                        '</tr>';
                        
                        if(data.sertifikat != null){
                            str += '<tr>'+
                                    '<td>Sertifikat</td>'+
                                    '<td><a href="'+baseUrl+'/upload/sertifikat_hki/'+data.sertifikat+'">Download</a></td>'+
                                '</tr>';
                        }
                        
                        str += '</table>';
            
                        $('#show').html(str);

                    }else{
                        $('#show').hide();
                        $('#show').empty();
                        $('#show2').show();
                        $('#show2').empty();
                        $('#btnUpdate').show();
                        var str = '';

                        var tgls = data.tanggal_publikasi.split('-');
                        var tgl = tgls[2]+'-'+tgls[1]+'-'+tgls[0];

                        str += '<table style="width:100%;">'+
                            '<tr>'+
                                '<td style="width:30%;">Catatan Revisi</td>'+
                                '<td style="width:70%;">'+
                                    '<p>'+data.catatan_revisi+'</p>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Nama</td>'+
                                '<td style="width:70%;">'+
                                    '<input type="text" required name="nama" id="nama" class="form-control" value="'+data.nama+'">'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Alamat dan Kode Pos</td>'+
                                '<td style="width:70%;">'+
                                    '<textarea name="alamat" id="alamat" class="form-control" rows="5">'+data.alamat+'</textarea>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">No Telp / HP</td>'+
                                '<td style="width:70%;">'+
                                    '<input type="text" required name="no_hp" id="no_hp" value="'+data.no_hp+'" class="form-control">'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Judul</td>'+
                                '<td style="width:70%;">'+
                                    '<input type="text" name="judul" id="judul" class="form-control" value="'+data.judul+'">'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td colspan="2">'+
                                    '<div class="col-lg-12 col-md-6 col-sm-12">'+
                                        '<div class="form-group row">'+
                                            '<label for="team">Anggota &nbsp;<button class="btn btn-primary" id="btnAddMember2" type="button" title="Tambah Anggota"><i class="fa fa-plus"></i></button></label>'+
                                            '<div class="col-sm-12">'+
                                                '<div class="table-responsive">'+
                                                    '<table class="table table-striped" id="tablememberhki2">'+
                                                        '<thead>'+
                                                            '<tr>'+
                                                                '<th><b>Nama</b></th>'+
                                                                '<th><b>Alamat dan Kode Pos</b></th>'+
                                                                '<th><b>No HP</b></th>'+
                                                                '<th><b>Action</b></th>'+
                                                            '</tr>'+
                                                        '</thead>'+
                                                        '<tbody>';
                                                        if(data.member.length > 0){
                                                            for(var i=0;i<data.member.length;i++){
                                                                str+= '<tr>'+
                                                                        '<td>'+
                                                                            '<input type="text" value="'+data.member[i].nama+'" placeholder="Nama Anggota" class="form-control namaMember" name="member[nama][]">'+
                                                                        '</td>'+
                                                                        '<td>'+
                                                                            '<textarea name="member[alamat][]" class="form-control alamatMember" rows="5">'+data.member[i].alamat+'</textarea>'+
                                                                        '</td>'+
                                                                        '<td>'+
                                                                            '<input type="text" value="'+data.member[i].no_hp+'" placeholder="No Telp / HP" class="form-control noHpMember" name="member[no_hp][]">'+
                                                                        '</td>'+
                                                                        '<td>'+
                                                                            '<button type="button" class="btn btn-danger btnremove" title="Hapus baris ini" id="btnRemove" onclick="deleteRow(this);" style="display:none;"><i class="fa fa-close"></i></button>'+
                                                                        '</td>'+
                                                                    '</tr>';
                                                            }
                                                        }else{
                                                            str+= '<tr>'+
                                                                '<td>'+
                                                                    '<input type="text" placeholder="Nama Anggota" class="form-control namaMember" name="member[nama][]">'+
                                                                '</td>'+
                                                                '<td>'+
                                                                    '<textarea name="member[alamat][]" class="form-control alamatMember" rows="5"></textarea>'+
                                                                '</td>'+
                                                                '<td>'+
                                                                    '<input type="text" placeholder="No Telp / HP" class="form-control noHpMember" name="member[no_hp][]">'+
                                                                '</td>'+
                                                                '<td>'+
                                                                    '<button type="button" class="btn btn-danger btnremove" title="Hapus baris ini" id="btnRemove" onclick="deleteRow(this);" style="display:none;"><i class="fa fa-close"></i></button>'+
                                                                '</td>'+
                                                            '</tr>';
                                                        }
                                                        str += '</tbody>'+
                                                    '</table>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Tanggal Publikasi</td>'+
                                '<td style="width:70%;">'+
                                    '<input type="text" name="tanggal_publikasi" id="tanggal_publikasi_2" class="form-control" value="'+tgl+'">'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Kota Publikasi</td>'+
                                '<td style="width:70%;">'+
                                    '<input type="text" name="nama_kota_publikasi" id="nama_kota_publikasi" class="form-control" value="'+data.nama_kota_publikasi+'">'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Resensi / Uraian</td>'+
                                '<td style="width:70%;">'+
                                    '<textarea name="resensi_uraian" id="resensi_uraian" class="form-control" rows="15">'+data.resensi_uraian+'</textarea>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Berkas KTP / NPWP sebelumnya</td>'+
                                '<td style="width:70%;">'+
                                    '<a href="'+baseUrl+'/upload/berkas_ktp_npwp/'+data.berkas_ktp_npwp+'">Download</a>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Berkas KTP / NPWP</td>'+
                                '<td style="width:70%;">'+
                                    '<input name="berkas_ktp_npwp" class="form-control" type="file">'+
                                    '<ul>'+
                                        '<li>'+
                                            '<p>Format file untuk diunggah adalah ekstensi *.jpg, *.jpeg, *.png, *.pdf <i class="fa fa-file"></i></p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Ukuran maksimal file adalah 2MB</p>'+
                                        '</li>'+
                                    '</ul>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Surat Pengalihan Hak Pemohon sebelumnya</td>'+
                                '<td style="width:70%;">'+
                                    '<a href="'+baseUrl+'/upload/surat_pengalihan_hak_pemohon/'+data.surat_pengalihan_hak_pemohon+'">Download</a>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Surat Pengalihan Hak Pemohon</td>'+
                                '<td style="width:70%;">'+
                                    '<input name="surat_pengalihan_hak_pemohon" class="form-control" type="file">'+
                                    '<ul>'+
                                        '<li>'+
                                            '<p>Format file untuk diunggah adalah ekstensi *.jpg, *.jpeg, *.png, *.pdf <i class="fa fa-file"></i></p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Ukuran maksimal file adalah 2MB</p>'+
                                        '</li>'+
                                    '</ul>'+                                
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Surat Pernyataan Pihak UMJ sebelumnya</td>'+
                                '<td style="width:70%;">'+
                                    '<a href="'+baseUrl+'/upload/surat_pernyataan_pihak_umj/'+data.surat_pernyataan_pihak_umj+'">Download</a>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Surat Pernyataan Pihak UMJ</td>'+
                                '<td style="width:70%;">'+
                                    '<input name="surat_pernyataan_pihak_umj" class="form-control" type="file">'+
                                    '<ul>'+
                                        '<li>'+
                                            '<p>Format file untuk diunggah adalah ekstensi *.jpg, *.jpeg, *.png, *.pdf <i class="fa fa-file"></i></p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Ukuran maksimal file adalah 2MB</p>'+
                                        '</li>'+
                                    '</ul>'+                                
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Karya Cipta sebelumnya</td>'+
                                '<td style="width:70%;">'+
                                    '<a href="'+baseUrl+'/upload/karya_cipta/'+data.karya_cipta+'">Download</a>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Karya Cipta</td>'+
                                '<td style="width:70%;">'+
                                    '<input name="surat_pernyataan_pihak_umj" class="form-control" type="file">'+
                                    '<ul>'+
                                        '<li>'+
                                            '<p>Format file untuk diunggah adalah ekstensi *.jpg, *.jpeg, *.png, *.pdf <i class="fa fa-file"></i></p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Ukuran maksimal file adalah 2MB</p>'+
                                        '</li>'+
                                    '</ul>'+                                
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Bukti Transfer sebelumnya</td>'+
                                '<td style="width:70%;">'+
                                    '<a href="'+baseUrl+'/upload/bukti_transfer/'+data.bukti_transfer+'">Download</a>'+
                                '</td>'+
                            '</tr>'+
                            '<tr><td colspan="2">&nbsp;</td></tr>'+
                            '<tr>'+
                                '<td style="width:30%;">Bukti Transfer</td>'+
                                '<td style="width:70%;">'+
                                    '<input name="bukti_transfer" class="form-control" type="file">'+
                                    '<ul>'+
                                        '<li>'+
                                            '<p>Format file untuk diunggah adalah ekstensi *.jpg, *.jpeg, *.png, *.pdf <i class="fa fa-file"></i></p>'+
                                        '</li>'+
                                        '<li>'+
                                            '<p>Ukuran maksimal file adalah 2MB</p>'+
                                        '</li>'+
                                    '</ul>'+                                
                                '</td>'+
                            '</tr>'+
                            '<input type="hidden" name="flag" value="1">'+
                            '<input type="hidden" name="id" value="'+data.pengajuan_insentif_hki_id+'">'+
                            '<input type="hidden" name="pengajuan_untuk" id="pengajuan_untuk" value="HKI">'+
                        '</table>';

                        $('#show2').html(str);
                        $('#tanggal_publikasi_2').datepicker({
                            format: "dd-mm-yyyy",
                            orientation: "bottom",
                            todayHighlight: true,
                            clearBtn: true
                        }).datepicker('setDate', $('#tanggal_publikasi_2').val());
                    }
                }else{
                    $('#show').show();
                    $('#show').empty();

                    var str = '<p>Tidak ada pengajuan</p>';
                    
                    $('#show').html(str);

                }
            }
        })
    }

    return false;
});

$(document).on('submit', '#formPengajuanHKI', function(){
    var formData = new FormData($(this)[0]);

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin memroses data ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#277de1",
        confirmButtonText: "Ya, Proses",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            window.swal({
                title: "Please wait",
                text: "File sedang diproses...",
                imageUrl: baseUrlImg,
                showConfirmButton: false,
                allowOutsideClick: false
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/insentif/pengajuan/store',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.status) {
                        swal({ title: "Success!", text: result.message, type: "success" },
                            function() {
                                $('#hkimodal').modal('hide');
                                
                                $('#formPengajuanHKI')[0].reset();
                                $('#show').hide();
                                $('#show2').hide();
                            })
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });


    return false;
});

$(document).on('submit', '#formUpdatePengajuanHKI', function(){
    var formData = new FormData($(this)[0]);

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin memroses data ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#277de1",
        confirmButtonText: "Ya, Proses",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            window.swal({
                title: "Please wait",
                text: "File sedang diproses...",
                imageUrl: baseUrlImg,
                showConfirmButton: false,
                allowOutsideClick: false
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/insentif/pengajuan/update/0',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.status) {
                        swal({ title: "Success!", text: result.message, type: "success" },
                            function() {
                                $('#detailHKI').modal('hide');
                                $('#show').hide();
                                $('#show2').hide();
                            })
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });


    return false;
});
$(document).on('click','#btnCloseHKI', function () {
    $('#show').hide();
    $('#show2').hide();
    $('.closes').click();
});

$(document).on('click', '.modalDetailInsentif', function(){
    $('#view_detail_insentif').modal('show');
    var id = $(this).attr('data-id');
    var url = '/insentif/pengajuan/show/'+id;
    $('.btnUpdate').attr('data-id', id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: url,
        success: function(data) {
            $('#appendInsentif').empty();

            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;

            var str = '';
            if(data.status_pengajuan == 'Surat Ajuan diunggah'){
                $('.btnUpdate').hide();
                $('.btnDownloadA').show();
                $('.btnDownloadA').attr('href', baseUrl+'/upload/surat_insentif/'+data.surat_insentif);
            }
            if(data.pengajuan_untuk == 'Jurnal'){
                str += '<tr>'+
                        '<td>Tanggal Pengajuan</td>'+
                        '<td>'+data.tanggal_pengajuan+'</td>'+
                    '</tr>'; 
                str += '<tr>'+
                        '<td>Nama Pemohon</td>'+
                        '<td>'+data.nama_dosen+'</td>'+
                    '</tr>'; 
                str += '<tr>'+
                        '<td>Jenis Publikasi</td>'+
                        '<td>'+data.nama+'</td>'+
                    '</tr>';

                str += '<tr>'+
                        '<td>Peran Penulis</td>'+
                        '<td>'+data.peran_penulis+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Judul</td>'+
                        '<td>'+data.judul+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Nama Jurnal</td>'+
                        '<td>'+data.nama_jurnal+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Tahun Publikasi</td>'+
                        '<td>'+data.tahun_publikasi+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Volume</td>'+
                        '<td>'+data.volume+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Nomor</td>'+
                        '<td>'+data.nomor+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>ISSN</td>'+
                        '<td>'+data.issn+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Tautan Jurnal</td>'+
                        '<td><a href="'+data.url+'" target="_blank">Klik</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                    '<td>Tautan ke Artikel Jurnal</td>'+
                    '<td><a href="'+data.url_artikel_jurnal+'" target="_blank">Klik</a></td>'+
                '</tr>';
                
                str += '<tr>'+
                    '<td>Tautan SINTA Penulis</td>'+
                    '<td><a href="'+data.url_sinta_penulis+'" target="_blank">Klik</a></td>'+
                '</tr>';

                str += '<tr>'+
                    '<td>Tautan ke Schimmagi / WOS / SINTA</td>'+
                    '<td><a href="'+data.url_schimmagi_wos_sinta+'" target="_blank">Klik</a></td>'+
                '</tr>';

                str += '<tr>'+
                        '<td>Biaya Publikasi Jurnal</td>'+
                        '<td>Rp '+formatMoney(data.biaya)+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Bukti Kwitansi Pengelola Jurnal</td>'+
                        '<td><a href="'+baseUrl+'/upload/bukti_kwitansi_pengelola_jurnal/'+data.bukti_kwitansi_pengelola_jurnal+'">Download</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                    '<td>Bukti Tangkapan Layar SINTA 3 pada Laman Penulis</td>'+
                    '<td><a href="'+baseUrl+'/upload/bukti_ss_sinta_3/'+data.bukti_ss_sinta_3+'">Download</a></td>'+
                '</tr>';
                
                str += '<tr>'+
                        '<td>Bukti Cek Plagiarisme</td>'+
                        '<td><a href="'+baseUrl+'/upload/bukti_cek_plagiarism/'+data.bukti_cek_plagiarism+'">Download</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Bukti Review Jurnal</td>'+
                        '<td><a href="'+baseUrl+'/upload/bukti_review_jurnal/'+data.bukti_review_jurnal+'">Download</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Berkas Jurnal</td>'+
                        '<td><a href="'+baseUrl+'/upload/berkas_pengajuan/'+data.berkas_pengajuan+'">Download</a></td>'+
                    '</tr>';
            }else if(data.pengajuan_untuk == 'Buku'){
                str += '<tr>'+
                        '<td>Tanggal Pengajuan</td>'+
                        '<td>'+data.tanggal_pengajuan+'</td>'+
                    '</tr>'; 
                str += '<tr>'+
                        '<td>Nama Pemohon</td>'+
                        '<td>'+data.nama_dosen+'</td>'+
                    '</tr>'; 
                str += '<tr>'+
                        '<td>Jenis Publikasi</td>'+
                        '<td>'+data.nama+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Judul</td>'+
                        '<td>'+data.judul+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Nama Penerbit</td>'+
                        '<td>'+data.nama_penerbit+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Tahun Terbit</td>'+
                        '<td>'+data.tahun_publikasi+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>ISBN</td>'+
                        '<td>'+data.isbn+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Tautan E-Book</td>'+
                        '<td><a href="'+data.url+'" target="_blank">Klik</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                    '<td>Tautan Laman Website Penerbit</td>'+
                    '<td><a href="'+data.url_website_penerbit+'" target="_blank">Klik</a></td>'+
                '</tr>';

                str += '<tr>'+
                        '<td>Biaya ke Penerbit</td>'+
                        '<td>Rp '+formatMoney(data.biaya)+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Bukti Transfer/Kwitansi ke Penerbit</td>'+
                        '<td><a href="'+baseUrl+'/upload/bukti_trf_penerbit/'+data.bukti_trf_penerbit+'">Download</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                    '<td>Cover dan Daftar Isi Buku</td>'+
                    '<td><a href="'+baseUrl+'/upload/cover_daftar_isi_buku/'+data.cover_daftar_isi_buku+'">Download</a></td>'+
                '</tr>';
                
                str += '<tr>'+
                        '<td>E-Book</td>'+
                        '<td><a href="'+baseUrl+'/upload/berkas_pengajuan/'+data.berkas_pengajuan+'">Download</a></td>'+
                    '</tr>';
            }else if(data.pengajuan_untuk == 'Prosiding'){
                str += '<tr>'+
                        '<td>Tanggal Pengajuan</td>'+
                        '<td>'+data.tanggal_pengajuan+'</td>'+
                    '</tr>'; 
                str += '<tr>'+
                        '<td>Nama Pemohon</td>'+
                        '<td>'+data.nama_dosen+'</td>'+
                    '</tr>'; 
                str += '<tr>'+
                        '<td>Jenis Prosiding</td>'+
                        '<td>'+data.nama+'</td>'+
                    '</tr>';
                str += '<tr>'+
                        '<td>Peran Penulis</td>'+
                        '<td>'+data.peran_penulis+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Judul</td>'+
                        '<td>'+data.judul+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Nama Prosiding</td>'+
                        '<td>'+data.nama_jurnal+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Tahun Prosiding</td>'+
                        '<td>'+data.tahun_publikasi+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Volume</td>'+
                        '<td>'+data.volume+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Nomor</td>'+
                        '<td>'+data.nomor+'</td>'+
                    '</tr>';
                
                if(data.issn != null){
                    str += '<tr>'+
                            '<td>ISSN</td>'+
                            '<td>'+data.issn+'</td>'+
                        '</tr>';
                }else{
                    str += '<tr>'+
                            '<td>ISBN</td>'+
                            '<td>'+data.isbn+'</td>'+
                        '</tr>';
                }
                
                str += '<tr>'+
                    '<td>URL</td>'+
                    '<td><a href="'+data.url+'" target="_blank">Klik</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                    '<td>Tautan SINTA Penulis</td>'+
                    '<td><a href="'+data.url_sinta_penulis+'" target="_blank">Klik</a></td>'+
                '</tr>';

                str += '<tr>'+
                        '<td>Biaya Prosiding</td>'+
                        '<td>Rp '+formatMoney(data.biaya)+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Bukti Kwitansi Pengelola Prosiding</td>'+
                        '<td><a href="'+baseUrl+'/upload/bukti_kwitansi_pengelola_jurnal/'+data.bukti_kwitansi_pengelola_jurnal+'">Download</a></td>'+
                    '</tr>';

                str += '<tr>'+
                    '<td>Bukti Tangkapan Layar SINTA 3 pada Laman Penulis</td>'+
                    '<td><a href="'+baseUrl+'/upload/bukti_ss_sinta_3/'+data.bukti_ss_sinta_3+'">Download</a></td>'+
                '</tr>';

                str += '<tr>'+
                        '<td>Bukti Cek Plagiarisme</td>'+
                        '<td><a href="'+baseUrl+'/upload/bukti_cek_plagiarism/'+data.bukti_cek_plagiarism+'"Download</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Bukti Review Prosiding</td>'+
                        '<td><a href="'+baseUrl+'/upload/bukti_review_jurnal/'+data.bukti_review_jurnal+'">Download</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Berkas Prosiding</td>'+
                        '<td><a href="'+baseUrl+'/upload/berkas_pengajuan/'+data.berkas_pengajuan+'">Download</a></td>'+
                    '</tr>';
            }else if(data.pengajuan_untuk == 'Media'){
                str += '<tr>'+
                        '<td>Tanggal Pengajuan</td>'+
                        '<td>'+data.tanggal_pengajuan+'</td>'+
                    '</tr>'; 
                str += '<tr>'+
                        '<td>Nama Pemohon</td>'+
                        '<td>'+data.nama_dosen+'</td>'+
                    '</tr>'; 
                str += '<tr>'+
                        '<td>Jenis Media</td>'+
                        '<td>'+data.nama+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Judul</td>'+
                        '<td>'+data.judul+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Nama Media Massa</td>'+
                        '<td>'+data.nama_media+'</td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Tanggal Terbit</td>'+
                        '<td>'+data.tanggal_terbit_media+'</td>'+
                    '</tr>';
                                
                str += '<tr>'+
                        '<td>URL</td>'+
                        '<td><a href="'+data.url+'" target="_blank">Klik</a></td>'+
                    '</tr>';
                
                str += '<tr>'+
                        '<td>Bukti Tangkapan Layar Berita Media Massa</td>'+
                        '<td><a href="'+baseUrl+'/upload/bukti_ss_media/'+data.bukti_ss_media+'">Download</a></td>'+
                    '</tr>';
            }

            $('#appendInsentif').html(str);
        }
    })
    
    return false;
});


$(document).on('click', '.modalDetailInsentifHKI', function(){
    $('#view_detail_insentif_hki').modal('show');
    var id = $(this).attr('data-id');
    var url = '/insentif/pengajuan/showhki/'+id;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: url,
        success: function(data) {
            $('#appendInsentifHKI').empty();

            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;

            var str = '';
            str += '<tr>'+
                    '<td>Nama Pemohon</td>'+
                    '<td>'+data.nama+'</td>'+
                '</tr>'; 
            str += '<tr>'+
                    '<td>No Telp / HP</td>'+
                    '<td>'+data.no_hp+'</td>'+
                '</tr>';
            str += '<tr>'+
                    '<td>Alamat</td>'+
                    '<td>'+data.alamat+'</td>'+
                '</tr>';
            str += '<tr>'+
                    '<td>Judul</td>'+
                    '<td>'+data.judul+'</td>'+
                '</tr>';
            
            str += '<tr>'+
                '<td>Anggota</td>'+
                '<td>'+
                    '<table class="table table-bordered">'+
                    '<tr>'+
                        '<td><b>Nama</b></td>'+
                        '<td><b>Alamat</b></td>'+
                        '<td><b>No Telp / HP</b></td>'+
                    '</tr>';
                    for(var i=0;i<data.member.length;i++){
                        str += '<tr>'+
                            '<td>'+data.member[i].nama+'</td>'+
                            '<td>'+data.member[i].alamat+'</td>'+
                            '<td>'+data.member[i].no_hp+'</td>'+
                        '</tr>';
                    }
                    str += '</table>'+
                '</td>'+
            '</tr>';
            str += '<tr>'+
                    '<td>Tanggal Publikasi</td>'+
                    '<td>'+data.tanggal_publikasi+'</td>'+
                '</tr>'; 

            str += '<tr>'+
                    '<td>Nama Kota Publikasi</td>'+
                    '<td>'+data.nama_kota_publikasi+'</td>'+
                '</tr>';
            str += '<tr>'+
                    '<td>Resensi / Uraian</td>'+
                    '<td>'+data.resensi_uraian+'</td>'+
                '</tr>';
            
            str += '<tr>'+
                    '<td>Berkas KTP / NPWP</td>'+
                    '<td><a href="'+baseUrl+'/upload/berkas_ktp_npwp/'+data.berkas_ktp_npwp+'">Download</a></td>'+
                '</tr>';
            
            str += '<tr>'+
                    '<td>Surat Pengalihan Hak Pemohon</td>'+
                    '<td><a href="'+baseUrl+'/upload/surat_pengalihan_hak_pemohon/'+data.surat_pengalihan_hak_pemohon+'">Download</a></td>'+
                '</tr>';

            str += '<tr>'+
                    '<td>Surat Pernyataan Pihak UMJ</td>'+
                    '<td><a href="'+baseUrl+'/upload/surat_pernyataan_pihak_umj/'+data.surat_pernyataan_pihak_umj+'</td>'+
                '</tr>';
            
            str += '<tr>'+
                    '<td>Karya Cipta</td>'+
                    '<td><a href="'+baseUrl+'/upload/karya_cipta/'+data.karya_cipta+'">Download</a></td>'+
                '</tr>';
            
            str += '<tr>'+
                '<td>Bukti Transfer</td>'+
                '<td><a href="'+baseUrl+'/upload/bukti_transfer/'+data.bukti_transfer+'">Download</a></td>'+
            '</tr>';
            
            if(data.status == 'Menunggu Validasi'){
                $('.btnUpdateHKI').show();
                $('.btnUploadSertifikat').hide();
                $('.btnUpdateHKI').attr('data-id', id);
            }else{
                $('.btnUpdateHKI').hide();
                $('.btnUploadSertifikat').show();
                $('.btnUploadSertifikat').attr('data-id', id);
            }

            $('#appendInsentifHKI').html(str);
        }
    })
    
    return false;
});

$(document).on('click', '.btnUpdate', function(){
    var id = $(this).attr('data-id');
    var status = $(this).attr('data-status');
    var url = '/insentif/pengajuan/updatepengajuan';

    if(status == 'validasi'){
        var post = {
            'id': id,
            'status': status
        };
        
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin memroses data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Ya, Proses",
            cancelButtonText: "Tidak",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: post,
                    url: url,
                    success: function(data) {
                        if (data.status) {
                            swal({ title: "Sukses", text: data.message, type: "success" },
                                function() {
                                    location.reload();
                                }
                            );
                        } else {
                            swal("Warning", data.message, "warning")
                        }
                    }
                })
            }
        });
    }else{
        $('#revisiInsentif').modal('show');
        $('#pengajuan_untuk').val('nonhki');
        $('#insentif_id').val(id);
    }

    return false;
});

$(document).on('click', '.btnUpdateHKI', function(){
    var id = $(this).attr('data-id');
    var status = $(this).attr('data-status');
    var url = '/insentif/pengajuan/updatepengajuan/hki';

    if(status == 'validasi'){
        var post = {
            'id': id,
            'status': status
        };
        
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin memroses data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Ya, Proses",
            cancelButtonText: "Tidak",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: post,
                    url: url,
                    success: function(data) {
                        if (data.status) {
                            swal({ title: "Sukses", text: data.message, type: "success" },
                                function() {
                                    location.reload();
                                }
                            );
                        } else {
                            swal("Warning", data.message, "warning")
                        }
                    }
                })
            }
        });
    }else{
        $('#revisiInsentif').modal('show');
        $('#pengajuan_untuk').val('hki');
        $('#insentif_id').val(id);
    }

    return false;
});

$(document).on('click', '#btnrevisiinsentif', function(){
    var id = $('#insentif_id').val();
    var status = 'revisi';
    var alasan = $('#noteInsentif').val();
    var tipe = $('#pengajuan_untuk').val();
    var post = {
        'id': id,
        'status': status,
        'alasan': alasan,
        'tipe': tipe
    };
    
    var url = '';
    if(tipe == 'hki'){
        url = '/insentif/pengajuan/updatepengajuan/hki';
    }else{
        url = '/insentif/pengajuan/updatepengajuan';
    }
    
    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin memroses data ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Proses",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: post,
                url: url,
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Sukses", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        }
    });

    return false;
});

$(document).on("click", ".batals", function() {
    var myId = $(this).data('id');
    $(".modal-body #proposalId").val(myId);
    // As pointed out in comments, 
    // it is unnecessary to have to manually call the modal.
    // $('#addBookDialog').modal('show');
});

$(document).on("click", "#btnpenolakan", function() {
    var id = $('#proposalId').val();
    var alasan = $('#alasan').val();
    var post = {};
    post.id = id;
    post.alasan = alasan;

    var url = '/proposalhibah/reject';
    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin membatalkan proposal ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Batalkan",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: post,
                url: url,
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Sukses", text: "Proposal ini dibatalkan", type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        }
    })
    return false;
});

$(document).on("click", "#btnreminder", function() {
    var id = $('#hibahId').val();
    var alasan = $('#alasan').val();
    var post = {};
    post.id = id;
    post.alasan = alasan;

    var url = '/hibah/send-reminder';
    swal({
        title: "Konfirmasi",
        text: "Anda yakin ingin mengirimkan pesan reminder ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Lanjutkan",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;
            var val = "assets/images/loading.gif";
            var baseUrlImg = baseUrl + "/" + val;

            window.swal({
                title: "Please wait",
                text: "Mohon tunggu...",
                imageUrl: baseUrlImg,
                showConfirmButton: false,
                allowOutsideClick: false
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: post,
                url: url,
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Sukses", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        }
    })
    return false;
});

$(document).on("click", "#cbId", function() {
    var a = JSON.parse(window.localStorage['id']);
    if ($(this).is(':checked'))
        a.push($(this).val());
    else
        a.splice(a.indexOf($(this).val()));
    window.localStorage['id'] = JSON.stringify(a);
});

$(document).on("click", ".rr1", function() {
    var a = JSON.parse(window.localStorage['id']);
    if ($(this).is(':checked'))
        a.push($(this).val());
    else
        a.splice(a.indexOf($(this).val()));
    window.localStorage['id'] = JSON.stringify(a);
});

$(document).on('click', '#btnsimpanreviewer', function() {
    var form_data = $("#form_rvw").serializeArray();
    console.log(form_data);
    var json = [];
    for (var i = 0; i < form_data.length; i++) {
        json.push(form_data[i].value);
    }
    $('#selected').html('Terpilih : ' + json.length);
    $('#reviewer_hidden').val(JSON.stringify(json));

    $('#reviewer').modal('hide');
    console.log(json);

    return false;
});

$(document).on('click', '#buttonchangerole', function() {
    var role_id = $('#role_id').val();
    var exist = $('#role_hide').val();

    if (exist != role_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/home/setrole',
            data: { role: role_id },
            success: function(data) {
                if (data.status) {
                    location.reload();
                }
            }
        });
    }

    return false;
});

$(document).on("click", ".viewhibah", function() {
    var id = $(this).data('id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/hibah/penelitian/get/" + id,
        success: function(data) {
            $('#tableDataHibah').append('<tr><td><b>Jenis Program</b></td><td>: ' + data.jenis_program + '</td></tr>');
            $('#tableDataHibah').append('<tr><td><b>Tahun Usulan</b></td><td>: ' + data.tahun_usulan_hibah + '</td></tr>');
            $('#tableDataHibah').append('<tr><td><b>Tahun Pelaksanaan</b></td><td>: ' + (data.tahun_pelaksanaan_hibah != null ? data.tahun_pelaksanaan_hibah : '-') + '</td></tr>');
            $('#tableDataHibah').append('<tr><td><b>Pelaksanaan</b></td><td>: ' + (formatDate(new Date(data.start_deadline_hibah))) + ' s.d ' + (formatDate(new Date(data.end_deadline_hibah))) + '</td></tr>');
            $('#tableDataHibah').append('<tr><td><b>Besaran Dana</b></td><td>: Rp ' + formatMoney(data.jumlah_pencairan_dana) + '</td></tr>');
            $('#tableDataHibah').append('<tr><td><b>Lama Pencairan Dana </b></td><td>: ' + data.lama_pencairan_dana + ' bulan</td></tr>');
            $('#tableDataHibah').append('<tr><td><b>Status Pengajuan</b></td><td>: ' + data.status_pengajuan_hibah + '</td></tr>');
            $('#tableDataHibah').append('<tr><td colspan="2"><b>Deadline Kegiatan</b><hr/></td></tr>');
            $('#tableDataHibah').append('<tr><td colspan="2"><div class="table-responsive"><table class="table table-striped>');

            console.log(data.deadline_hibah);
            for (var i = 0; i < data.deadline_hibah.length; i++) {
                $('#tableDataHibah').append('<tr><td><b>' + data.deadline_hibah[i].jenis_kegiatan + '</b></td><td>' + formatDate(new Date(data.deadline_hibah[i].start_date)) + ' s.d ' + formatDate(new Date(data.deadline_hibah[i].end_date)) + '</td></tr>');
            }
            $('#tableDataHibah').append('</table></div></td></tr>');
        }
    })

    // As pointed out in comments, 
    // it is unnecessary to have to manually call the modal.
    // $('#addBookDialog').modal('show');
});

function formatDate(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return (date.getDate() < 10 ? '0' + date.getDate() : date.getDate()) + '-' + (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + "-" + date.getFullYear();
}

function stripHtml(html){
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent || tmp.innerText || "";
}


function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
    if(amount == null){
        amount = 0;
    }
    try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
    }
}

$(document).on('click', '#cbs1', function() {
    if ($(this).prop('checked')) {
        $('#showException').show();
    } else {
        //disable
        $('#showException').hide();
        $("#selectException").val([]);
        $("#selectException").selectpicker("refresh");
    }
});

$(document).on('click', '#cbs2', function() {
    if ($(this).prop('checked')) {
        $('.syarat_pangkat').prop('disabled', false);
        $('#syarat_pangkat1').prop('checked', true);
    } else {
        $('#syarat_pangkat1').prop('checked', false);
        $('#syarat_pangkat2').prop('checked', false);
        $('#syarat_pangkat3').prop('checked', false);
        $('#syarat_pangkat4').prop('checked', false);

        //disable
        $('.syarat_pangkat').prop('disabled', true);
    }
});

//function untuk onclick button
//parameternya adalah url
function openForm(url) {
    window.location = url;
}

$('.searchdata').keyup(function() {
    var query = $('.searchdata').val();
    console.info('query', query);
    var column_name = $('.hidden_column_name').val();
    var sort_type = $('.hidden_sort_type').val();
    var page = $('.hidden_page').val();
    var tipeform = $('.tipe_form').val();
    var size = $('.size').val();
    fetch_data(page, sort_type, column_name, query, tipeform, size);
});

$(document).ready(function() {
    window.localStorage['id'] = '[]';
    window.localStorage['id2'] = '[]';

    $('#tableFakultas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/umum/fakultas/getfakultas',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'fakultas_id', name: 'hibah_id', orderable: false, searchable: false, visible: false },
            { data: 'kode_fakultas', name: 'kode_fakultas' },
            { data: 'nama_fakultas', name: 'nama_fakultas' },
            { data: 'nama_ketua', name: 'nama_ketua' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            }
        ]
    });

    $('#tableHibahInternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/hibah/penelitian/internal/get',
        columns: [
            { data: 'hibah_id', name: 'hibah_id', orderable: false, searchable: false, visible: false },
            { data: 'hibah_code', name: 'hibah_code' },
            { data: 'tipe_penyelenggaraan_hibah', name: 'tipe_penyelenggaraan_hibah', orderable: false, searchable: false, visible: false },
            { data: 'jenis_program', name: 'jenis_program' },
            { data: 'tahun_usulan_hibah', name: 'tahun_usulan_hibah' },
            { data: 'tahun_pelaksanaan_hibah', name: 'tahun_pelaksanaan_hibah' },
            { data: 'status_pengajuan_hibah', name: 'status_pengajuan_hibah' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableHibahInternal').on('click', '#sendreminder', function(){
        var id = $(this).attr('data-id');
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "Kirim Pengingat sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/hibah/send-reminder/'+id,
            type: 'GET',
            success: function(result) {
                swal("Success", result.message, "success");
            },
            error: function(data) {
                console.log(data);
            }
        });

        return false;
    });

    $('#tableHibahInternalAbdimas').on('click', '#sendreminder', function(){
        var id = $(this).attr('data-id');
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "Kirim Pengingat sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/hibah/send-reminder/'+id,
            type: 'GET',
            success: function(result) {
                swal("Success", result.message, "success");
            },
            error: function(data) {
                console.log(data);
            }
        });

        return false;
    });

    $('#tableHibahEksternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/hibah/penelitian/eksternal/get',
        columns: [
            { data: 'hibah_id', name: 'hibah_id', orderable: false, searchable: false, visible: false },
            { data: 'hibah_code', name: 'hibah_code' },
            { data: 'tipe_penyelenggaraan_hibah', name: 'tipe_penyelenggaraan_hibah', orderable: false, searchable: false, visible: false },
            { data: 'jenis_program', name: 'jenis_program' },
            { data: 'tahun_usulan_hibah', name: 'tahun_usulan_hibah' },
            { data: 'tahun_pelaksanaan_hibah', name: 'tahun_pelaksanaan_hibah' },
            { data: 'status_pengajuan_hibah', name: 'status_pengajuan_hibah' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableHibahInternalAbdimas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/hibah/abdimas/internal/get',
        columns: [
            { data: 'hibah_id', name: 'hibah_id', orderable: false, searchable: false, visible: false },
            { data: 'hibah_code', name: 'hibah_code' },
            { data: 'tipe_penyelenggaraan_hibah', name: 'tipe_penyelenggaraan_hibah', orderable: false, searchable: false, visible: false },
            { data: 'jenis_program', name: 'jenis_program' },
            { data: 'tahun_usulan_hibah', name: 'tahun_usulan_hibah' },
            { data: 'tahun_pelaksanaan_hibah', name: 'tahun_pelaksanaan_hibah' },
            { data: 'status_pengajuan_hibah', name: 'status_pengajuan_hibah' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableHibahEksternalAbdimas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/hibah/abdimas/eksternal/get',
        columns: [
            { data: 'hibah_id', name: 'hibah_id', orderable: false, searchable: false, visible: false },
            { data: 'hibah_code', name: 'hibah_code' },
            { data: 'tipe_penyelenggaraan_hibah', name: 'tipe_penyelenggaraan_hibah', orderable: false, searchable: false, visible: false },
            { data: 'jenis_program', name: 'jenis_program' },
            { data: 'tahun_usulan_hibah', name: 'tahun_usulan_hibah' },
            { data: 'tahun_pelaksanaan_hibah', name: 'tahun_pelaksanaan_hibah' },
            { data: 'status_pengajuan_hibah', name: 'status_pengajuan_hibah' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableProposal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/proposalhibah/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_dosen.proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.hibah_untuk == 'Umum' ? 'LPPM' : row.nama_fakultas) +'<br>'+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'proposal_dosen.judul_proposal' },
            {
                data: 'nama_anggota',
                name : "CONCAT(GROUP_CONCAT(dosen.nama_dosen SEPARATOR ';'),';', COALESCE(GROUP_CONCAT(proposal_hibah_member.nama_mahasiswa SEPARATOR ';'),'')) ",
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    if(row.nama_anggota == null){
                        str = '-';
                    }else{
                        if(row.nama_anggota.charAt(row.nama_anggota.length-1) == ';')
                            row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                        a = row.nama_anggota.split(';');
                        for (var i = 0; i < a.length; i++) {
                            str += (i + 1) + '. ' + a[i] + '<br>';
                        }
                    }
                    return str;
                }
            },
            { data: 'updated_at', name: 'proposal_dosen.updated_at' },
            { data: 'status_proposal', name: 'proposal_dosen.status_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tabelDanaPenelitianInt').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/sumber_daya/sumberdana/get/internal/penelitian',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
            { data: 'hibah_id', name: 'hibah.hibah_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.hibah_untuk == 'Umum' ? 'LPPM' : row.nama_fakultas) +'<br>'+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'proposal_dosen.judul_proposal' },
            {
                data: 'nama_anggota',
                name : "CONCAT(GROUP_CONCAT(dosen.nama_dosen SEPARATOR ';'),';', COALESCE(GROUP_CONCAT(proposal_hibah_member.nama_mahasiswa SEPARATOR ';'),'')) ",
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    if(row.nama_anggota.charAt(row.nama_anggota.length-1) == ';')
                        row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            {
                data: 'jumlah_pencairan_dana',
                name: 'hibah.jumlah_pencairan_dana',
                render: function(data, type, row) {
                    var str = row.jenis_program + '<br>Jumlah Pencairan Dana : Rp ' + formatMoney( row.jumlah_pencairan_dana);
                    return str;
                }
            }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tabelDanaPenelitianExt').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/sumber_daya/sumberdana/get/eksternal/penelitian',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
            { data: 'hibah_id', name: 'hibah.hibah_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.hibah_untuk == 'Umum' ? 'LPPM' : row.nama_fakultas) +'<br>'+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'proposal_dosen.judul_proposal' },
            {
                data: 'nama_anggota',
                name : "CONCAT(GROUP_CONCAT(dosen.nama_dosen SEPARATOR ';'),';', COALESCE(GROUP_CONCAT(proposal_hibah_member.nama_mahasiswa SEPARATOR ';'),'')) ",
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    if(row.nama_anggota.charAt(row.nama_anggota.length-1) == ';')
                        row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            {
                data: 'jumlah_dana_hibah_ext',
                name: 'proposal_dosen.jumlah_dana_hibah_ext',
                render: function(data, type, row) {
                    var str = row.jenis_program + '<br>Jumlah Pencairan Dana : Rp ' + formatMoney( row.jumlah_dana_hibah_ext );
                    return str;
                }
            }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tabelDanaAbdimasInt').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/sumber_daya/sumberdana/get/internal/abdimas',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
            { data: 'hibah_id', name: 'hibah.hibah_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.hibah_untuk == 'Umum' ? 'LPPM' : row.nama_fakultas) +'<br>'+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'proposal_dosen.judul_proposal' },
            {
                data: 'nama_anggota',
                name : "CONCAT(GROUP_CONCAT(dosen.nama_dosen SEPARATOR ';'),';', COALESCE(GROUP_CONCAT(proposal_hibah_member.nama_mahasiswa SEPARATOR ';'),'')) ",
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    if(row.nama_anggota.charAt(row.nama_anggota.length-1) == ';')
                        row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            {
                data: 'jumlah_pencairan_dana',
                name: 'hibah.jumlah_pencairan_dana',
                render: function(data, type, row) {
                    var str = row.jenis_program + '<br>Jumlah Pencairan Dana : Rp ' + formatMoney( row.jumlah_pencairan_dana);
                    return str;
                }
            },
            {
                data: 'mitra_hibah',
                name: 'proposal_dosen.mitra_hibah'
            },
            {
                data: 'provinsi',
                name: 'provinces.name',
                render: function(data, type, row) {
                    var str = 'Desa '+row.desa + ' Kecamatan ' + row.kecamatan +' Kota '+row.kota+' Provinsi '+row.provinsi;
                    return str;
                }
            },
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5,6,7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5,6,7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5,6,7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5,6,7]
                }
            }
        ]
    });

    $('#tabelDanaAbdimasExt').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/sumber_daya/sumberdana/get/eksternal/abdimas',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
            { data: 'hibah_id', name: 'hibah.hibah_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.hibah_untuk == 'Umum' ? 'LPPM' : row.nama_fakultas) +'<br>'+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'proposal_dosen.judul_proposal' },
            {
                data: 'nama_anggota',
                name : "CONCAT(GROUP_CONCAT(dosen.nama_dosen SEPARATOR ';'),';', COALESCE(GROUP_CONCAT(proposal_hibah_member.nama_mahasiswa SEPARATOR ';'),'')) ",
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    if(row.nama_anggota.charAt(row.nama_anggota.length-1) == ';')
                        row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            {
                data: 'jumlah_dana_hibah_ext',
                name: 'proposal_dosen.jumlah_dana_hibah_ext',
                render: function(data, type, row) {
                    var str = row.jenis_program + '<br>Jumlah Pencairan Dana : Rp ' + formatMoney( row.jumlah_dana_hibah_ext );
                    return str;
                }
            },
            {
                data: 'mitra_hibah',
                name: 'proposal_dosen.mitra_hibah'
            },
            {
                data: 'provinsi',
                name: 'provinces.name',
                render: function(data, type, row) {
                    var str = 'Desa '+row.desa + ' Kecamatan ' + row.kecamatan +' Kota '+row.kota+' Provinsi '+row.provinsi;
                    return str;
                }
            },
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5,6,7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5,6,7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5,6,7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5,6,7]
                }
            }
        ]
    });

    $.fn.dataTable.render.example1 = function () {
        return function ( data, type, row ) {
            var str = (row.hibah_untuk=='Umum' ? 'LPPM' : row.nama_fakultas)+'<br>'+row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
            if (type === 'display') {
                return str;
            }else if (type === 'filter') {
                return str;
            }
            return data;
        };
    };

    $.fn.dataTable.render.example2 = function () {
        return function ( data, type, row ) {
            var a = null;
            var str = '';
            if(row.nama_anggota.charAt(row.nama_anggota.length-1) == ';')
                row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
            a = row.nama_anggota.split(';');
            for (var i = 0; i < a.length; i++) {
                str += (i + 1) + '. ' + a[i] + '<br>';
            }
            if (type === 'display') {
                return str;
            }else if (type === 'filter') {
                return str;
            }
            return data;
        };
    };

    $.fn.dataTable.render.example3 = function () {
        return function ( data, type, row ) {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;
            var val = "upload/proposal/" +row.proposal_file;
            var baseUrlImg = baseUrl + "/" + val;
            var str = row.judul_proposal + '<br><a href="'+baseUrlImg+'" target="_blank">Download</a>';
            if (type === 'display') {
                return str;
            }else if (type === 'filter') {
                return data;
            }
            return data;
        };
    };

    $('#tableProposalDiajukanAbdimas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/proposalhibah/getlistproposal/hibahabdimas',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_dosen.proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                searchable: true,
                render: $.fn.dataTable.render.example1()
            },
            {
                data: 'nama_anggota',
                name : "proposal_hibah_member.nama_anggota",
                searchable: true,
                render: $.fn.dataTable.render.example2()
            },
            {   
                data: 'judul_proposal', 
                name: 'proposal_dosen.judul_proposal',
                searchable: true,
                render: $.fn.dataTable.render.example3()
            },
            { data: 'status_menilai', name: 'reviewer_proposal_hibah.status_menilai' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableProposalDiajukanPenelitian').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/proposalhibah/getlistproposal/hibahpenelitian',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_dosen.proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                searchable: true,
                render: $.fn.dataTable.render.example1()
            },
            {
                data: 'nama_anggota',
                name : "proposal_hibah_member.nama_anggota",
                searchable: true,
                render: $.fn.dataTable.render.example2()
            },
            {   
                data: 'judul_proposal', 
                name: 'proposal_dosen.judul_proposal',
                searchable: true,
                render: $.fn.dataTable.render.example3()
            },
            { data: 'status_menilai', name: 'reviewer_proposal_hibah.status_menilai' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            }
        ]
    });

    
    $('#tableMonevPenelitian').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getdatamonev/penelitian',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_dosen.proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.hibah_untuk=='Umum' ? 'LPPM' : row.kode_fakultas)+'<br>'+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            {
                data: 'nama_anggota',
                name : "CONCAT(GROUP_CONCAT(dosen.nama_dosen SEPARATOR ';'),';', COALESCE(GROUP_CONCAT(proposal_hibah_member.nama_mahasiswa SEPARATOR ';'),'')) ",
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    if(row.nama_anggota.charAt(row.nama_anggota.length-1) == ';')
                        row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            {   
                data: 'judul_proposal', 
                name: 'proposal_dosen.judul_proposal',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/proposal/" +row.proposal_file;
                    var baseUrlImg = baseUrl + "/" + val;
                    var str = row.judul_proposal + '<br><a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    return str;
                }
            },
            { data: 'status_proposal', name: 'status_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableMonevAbdimas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getdatamonev/abdimas',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_dosen.proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.hibah_untuk=='Umum' ? 'LPPM' : row.kode_fakultas)+'<br>'+row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            {
                data: 'nama_anggota',
                name : "CONCAT(GROUP_CONCAT(dosen.nama_dosen SEPARATOR ';'),';', COALESCE(GROUP_CONCAT(proposal_hibah_member.nama_mahasiswa SEPARATOR ';'),'')) ",
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    if(row.nama_anggota.charAt(row.nama_anggota.length-1) == ';')
                        row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            {   
                data: 'judul_proposal', 
                name: 'proposal_dosen.judul_proposal',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/proposal/" +row.proposal_file;
                    var baseUrlImg = baseUrl + "/" + val;
                    var str = row.judul_proposal + '<br><a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    return str;
                }
            },
            { data: 'status_proposal', name: 'status_proposal' }, 
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableRiwayatPenelitian').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/riwayatusulan/getRiwayat/penelitian',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            { data: 'jenis_program', name: 'jenis_program' },
            { data: 'tahun_pelaksanaan_hibah', name: 'tahun_pelaksanaan_hibah' },
            { data: 'jabatan', name: 'jabatan' },
            {
                data: 'nama_anggota',
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        if(i == a.length - 1){
                            if(a[i] != '')
                                str += (i + 1) + '. ' + a[i] + '<br>';
                        }else{
                            str += (i + 1) + '. ' + a[i] + '<br>';
                        }
                    }
                    return str;
                }
            },
            { data: 'status_proposal', name: 'status_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [1, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tablePengajuanDashboard').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/proposalhibah/getpengajuan',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_hibah',
                render: function(data, type, row) {
                    var str = (row.nama_fakultas ? row.nama_fakultas : 'LPPM') +
                    '<br>'+row.jenis_program +
                    '<br>'+row.jenis_hibah +
                    '<br>'+ 'Tahun '+row.tahun_pelaksanaan_hibah;

                    return str;
                }
            },
            {
                data: 'nama_anggota',
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    a = row.nama_anggota.split('; ');
                    for (var i = 0; i < a.length; i++) {
                        if(i == a.length - 1){
                            if(a[i] != '')
                                str += a[i];
                        }else{
                            var spl = a[i].split('|');
                            if(spl.length > 1){
                                if(i == 0){
                                    str += '<a class="ketua-pengusul-detail" href="#" data-id="'+spl[0]+'" style="color: red;">'+spl[1]+' <b>(Ketua Pengusul)</b></a><br/>';
                                }else{
                                    str += spl[1]+'<br/>';
                                }
                            }else{
                                str += a[i]+'<br/>';
                                console.log(str);
                            }
                        }
                    }
                    return str;
                }
            },
            {
                data: 'proposal_file',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/proposal/" +row.proposal_file;
                    var baseUrlImg = baseUrl + "/" + val;
                    var str = '';
                    str += row.judul_proposal+'<br/>';
                    str += '<a target="_blank" href="'+baseUrlImg+'">Download Usulan</a>';
                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip'
    });

    $('#tablePengajuanInsentifDashboard').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/pengajuan/getpersetujuan',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pengajuan_insentif_id', name: 'pengajuan_insentif_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'tanggal_pengajuan', name: 'tanggal_pengajuan' },
            { data: 'pengajuan_untuk', name: 'pengajuan_untuk' },
            { data: 'judul', name: 'judul' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tablePengajuanInsentifDOIDashboard').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/doi/getpersetujuan',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pengajuan_insentif_doi_id', name: 'pengajuan_insentif_doi_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'tanggal_pengajuan', name: 'tanggal_pengajuan' },
            { data: 'nama_jurnal', name: 'nama_jurnal' },
            { data: 'str', name: 'str' },
            { data: 'jumlah_artikel', name: 'jumlah_artikel' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            }
        ]
    });

    $('#tablePengajuanInsentifPjDashboard').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/pengelola_jurnal/getpersetujuan',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pengajuan_insentif_pj_id', name: 'pengajuan_insentif_pj_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'tanggal_pengajuan', name: 'tanggal_pengajuan' },
            { data: 'nama_jurnal', name: 'nama_jurnal' },
            { data: 'str', name: 'str' },
            { data: 'jumlah_artikel', name: 'jumlah_artikel' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            }
        ]
    });

    $('#tablePengajuanInsentifHKI').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/pengajuan/getpersetujuan/hki',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pengajuan_insentif_hki_id', name: 'pengajuan_insentif_hki_id', orderable: false, searchable: false, visible: false },
            { data: 'nama', name: 'nama' },
            { data: 'tanggal_pengajuan', name: 'tanggal_pengajuan' },
            { data: 'judul', name: 'judul' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip'
    });

    $('#tableRiwayatAbdimas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/riwayatusulan/getRiwayat/abdimas',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            { data: 'jenis_program', name: 'jenis_program' },
            { data: 'tahun_pelaksanaan_hibah', name: 'tahun_pelaksanaan_hibah' },
            { data: 'jabatan', name: 'jabatan' },
            {
                data: 'nama_anggota',
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        if(i == a.length - 1){
                            if(a[i] != '')
                                str += (i + 1) + '. ' + a[i] + '<br>';
                        }else{
                            str += (i + 1) + '. ' + a[i] + '<br>';
                        }
                    }
                    return str;
                }
            },
            { data: 'status_proposal', name: 'status_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableDataAdminLppm').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/admin_lppm/get_data_admin_lppm',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'user_id', name: 'user_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var tableMonevLaporanLuaran = $('#tableMonevLaporanLuaran').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getlaporanluaran',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.kode_fakultas!=null ? row.kode_fakultas : 'LPPM') +'<br>'+ row.jenis_hibah+' - '+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            {
                data: 'nama_anggota',
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'judul_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var tableMonevCatatanPenelitian = $('#tableMonevCatatanPenelitian').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getcatatanharian/penelitian',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.kode_fakultas!=null ? row.kode_fakultas : 'LPPM') +'<br>'+ row.jenis_hibah+' - '+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            {
                data: 'nama_anggota',
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'judul_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    
    var tableMonevCatatanAbdimas = $('#tableMonevCatatanAbdimas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getcatatanharian/abdimas',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.kode_fakultas!=null ? row.kode_fakultas : 'LPPM') +'<br>'+ row.jenis_hibah+' - '+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            {
                data: 'nama_anggota',
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'judul_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var tableMonevLaporanAkhir = $('#tableMonevLaporanAkhir').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getlaporanakhir',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = (row.kode_fakultas!=null ? row.kode_fakultas : 'LPPM') +'<br>'+ row.jenis_hibah+' - '+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            {
                data: 'nama_anggota',
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'judul_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var url = window.location.href;
    var urls = url.split('/');
    var url1 = urls[urls.length - 3];
    var url2 = urls[urls.length - 2];
    var url3 = urls[urls.length - 1];
    var urlfix = '';
    if(!isNaN(url1)){
        urlfix = url1+'/'+url2+'/'+url3;
    }else{
        urlfix = url2+'/'+url3;
    }
    console.info('urlfix',urlfix)
    $('#tableMonevAllCatatan').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getallcatatanharian/'+urlfix,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'catatan_harian_id', name: 'catatan_harian_id', orderable: false, searchable: false, visible: false },
            { data: 'tgl_kegiatan', name: 'tgl_kegiatan' },
            { 
                data: 'uraian_catatan', 
                render: function ( data, type, row ) {
                    return stripHtml(data);
                },
            },
            { data: 'persentase_kegiatan', name: 'persentase_kegiatan' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    
    $('#tableMonevAllLaporanAkhir').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getalllaporanakhir/'+urlfix,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'laporan_akhir_id', name: 'laporan_akhir_id', orderable: false, searchable: false, visible: false },
            { data: 'created_at', name: 'laporan_akhir.created_at' },
            { data: 'laporan_akhir_file', name: 'laporan_akhir_file' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    $('#tableMonevAllPoster').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getalllaporanluaran/poster/'+urlfix,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'poster_id', name: 'poster_id', orderable: false, searchable: false, visible: false },
            { data: 'created_at', name: 'poster.created_at' },
            { data: 'judul_poster', name: 'judul_poster' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    $('#tableMonevAllLuaranLainnya').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getalllaporanluaran/luaranlain/'+urlfix,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'id', name: 'id', orderable: false, searchable: false, visible: false },
            { data: 'flag', name: 'flag'},
            { data: 'judul', name: 'judul' },
            { data: 'jenis', name: 'jenis' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    $('#tableMonevAllPemakalah').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getalllaporanluaran/pemakalah/'+urlfix,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pemakalah_id', name: 'pemakalah_id', orderable: false, searchable: false, visible: false },
            {
                data: 'nama_forum',
                render: function(data, type, row) {
                    var str = '<b>Nama Forum</b> : '+row.nama_forum + '<br>';
                    str += '<b>Penyelenggara</b> : ' + row.institusi_penyelenggara +'<br>';
                    str += '<b>Tempat</b> : '+row.tempat_pelaksanaan+'<br>';
                    str += '<b>Tanggal</b> : '+row.tanggal_mulai+' s.d '+row.tanggal_akhir;

                    return str;
                }
            },
            {   
                data: 'judul_makalah', 
                render: function(data, type, row) {
                    var str = '<b>Judul Makalah</b> : '+row.judul_makalah + '<br>';
                    str += '<b>Status</b> : '+row.status_pemakalah + '<br>';

                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    $('#tableMonevAllPublikasi').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/monev/getalllaporanluaran/publikasi/'+urlfix,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'publikasi_jurnal_id', name: 'publikasi_jurnal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'nama_jurnal',
                render: function(data, type, row) {
                    var str = '<b>Nama Jurnal</b> : '+row.nama_personil + '<br>';
                    str += '<b>Tingkat</b> : ' + row.tingkat_jurnal +'<br>';
                    str += '<b>ISSN</b> : '+ row.issn +'<br>';
                    str += '<b>Impact Factor</b> : '+row.impact_factor;

                    return str;
                }
            },
            {   
                data: 'judul', 
                render: function(data, type, row) {
                    if(row.url != null){
                        var url = '<b>URL</b> : <a href="'+row.url+'" target="_blank">'+row.url+'</a><br>';
                    } 
                    if(row.url == 0){
                        var url = "<b>URL</b> : -<br>";
                    }
                    if (row.url == '-'){
                        var url = "<b>URL</b> : -<br>";
                    }
                    if (row.url == ''){
                        var url = "<b>URL</b> : -<br>";
                    }
                    if (row.url == undefined){
                        var url = "<b>URL</b> : -<br>";
                    }

                    var str = '<b>Judul Publikasi</b> : '+row.judul + '<br>';
                    str += url;
                    str += '<b>Status</b> : '+row.status_naskah + '<br>';

                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });

    $(document).on('change','#filterHibah', function(){
        if($(this).val()!=""){
            tableMonevCatatanPenelitian.ajax.url( '/monev/getcatatanharian/penelitian/'+$(this).val() ).load();
            tableMonevCatatanAbdimas.ajax.url( '/monev/getcatatanharian/abdimas/'+$(this).val() ).load();
        }else{
            tableMonevCatatanPenelitian.ajax.url( '/monev/getcatatanharian/penelitian').load();
            tableMonevCatatanAbdimas.ajax.url( '/monev/getcatatanharian/abdimas').load();
        }
    });

    $(document).on('change','#filterHibahLA', function(){
        if($(this).val()!="")
            tableMonevLaporanAkhir.ajax.url( '/monev/getlaporanakhir/'+$(this).val() ).load();
        else
            tableMonevLaporanAkhir.ajax.url( '/monev/getlaporanakhir' ).load();
    });

    $(document).on('change','#filterHibahLL', function(){
        if($(this).val()!="")
            tableMonevLaporanLuaran.ajax.url( '/monev/getlaporanluaran/'+$(this).val() ).load();
        else
            tableMonevLaporanLuaran.ajax.url( '/monev/getlaporanluaran' ).load();
    });

    $(document).on('change','#filterYearHibah', function(){
        if($(this).val()!="")
            tableLaporanAkhir.ajax.url( '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir/'+$(this).val() ).load();
        else
            tableLaporanAkhir.ajax.url( '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir' ).load();
    });

    $('#tableDataAdminFakultas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/admin_fakultas/getall',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'user_id', name: 'user_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableUnitFasilitas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/unitfasilitas/getunitfasilitas/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'unit_id', name: 'unit_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_unit', name: 'nama_unit' },
            { data: 'no_sk_pendirian', name: 'no_sk_pendirian' },
            { data: 'fasilitas', name: 'fasilitas' },
            { data: 'status_fasilitas_penunjang', name: 'status_fasilitas_penunjang' },
            {   
                data: 'berkas_sk_pendirian', 
                name: 'berkas_sk_pendirian',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/unit_fasilitas/" +row.berkas_sk_pendirian;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_sk_pendirian != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            {   
                data: 'berkas_sertifikat', 
                name: 'berkas_sertifikat',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/unit_fasilitas/" +row.berkas_sertifikat;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_sertifikat != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });
    
    $('#tableUnitBisnis').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/unitbisnishasilriset/getbisnisriset/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'unit_bisnis_hasil_riset_id', name: 'unit_bisnis_hasil_riset_id', orderable: false, searchable: false, visible: false },
            {
                data: 'nama_unit_bisnis',
                render: function(data, type, row) {
                    var str = row.nama_unit_bisnis + '<br>No. SK : ' + row.no_sk_pendirian + '<br>Mitra : ' + row.mitra_bisnis;
                    return str;
                }
            },
            { data: 'lingkup_kegiatan', name: 'lingkup_kegiatan' },
            {
                data: 'file_sk_pendirian',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/bisnisriset/" +row.file_sk_pendirian;
                    var baseUrlImg = baseUrl + "/" + val;

                    if(row.file_sk_pendirian !== null){
                        var str = '<a href="'+baseUrlImg+'" class="btn btn-icon" title="Unduh Dokumen" target="_blank">Download Dokumen</a>';
                    } else {
                        var str = 'Belum upload dokumen';
                    }
                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });
    
    $('#tableKontrakKerja').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/kontrakkerja/getkontrakkerja/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'kontrak_kerja_id', name: 'kontrak_kerja_id', orderable: false, searchable: false, visible: false },
            {
                data: 'nama_unit_pelaksana',
                render: function(data, type, row) {
                    var str = row.nama_unit_pelaksana + '<br>Mitra : ' + row.mitra_kerja;
                    return str;
                }
            },
            { data: 'nama_kegiatan', name: 'nama_kegiatan' },
            {
                data: 'nilai_kontrak',
                render: function(data, type, row) {
                    var str = 'Nilai : '+row.nilai_kontrak + '<br>No. : ' + row.no_kontrak;
                    return str;
                }
            },
            {
                data: 'file_kontrak',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/kontrak_kerja/" +row.file_kontrak;
                    var baseUrlImg = baseUrl + "/" + val;

                    if(row.file_kontrak !== null){
                        var str = '<a href="'+baseUrlImg+'" title="Unduh Dokumen" target="_blank">Download Dokumen</a>';
                    } else {
                        var str = 'Belum upload dokumen';
                    }
                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableForumIlmiah').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/forumilmiah/getforumilmiah/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'forum_ilmiah_id', name: 'forum_ilmiah_id', orderable: false, searchable: false, visible: false },
            { data: 'tingkat_forum_ilmiah', name: 'tingkat_forum_ilmiah' },
            { data: 'nama_kegiatan', name: 'nama_kegiatan' },
            { data: 'unit_pelaksana', name: 'unit_pelaksana' },
            { data: 'tempat_kegiatan', name: 'tempat_kegiatan' },
            {
                data: 'tanggal_pelaksanaan',
                render: function(data, type, row) {
                    return row.tgl_mulai + ' s.d ' + row.tgl_akhir;
                }
            },
            { data: 'tahun', name: 'tahun', visible: false, orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
            //{ data: 'tgl_mulai', name:'tgl_mulai', orderable: false, searchable: false },
            // { data: 'tgl_akhir', name:'tgl_akhir', orderable: false, searchable: false },
            // { data: 'keterangan_valid', name:'keterangan_valid', orderable: false, searchable: false },
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    $('#tablePeriodeInsentif').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/periode/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'periode_pengajuan_insentif_id', name: 'periode_pengajuan_insentif_id', orderable: false, searchable: false, visible: false },
            { data: 'tanggal_mulai', name: 'tanggal_mulai' },
            { data: 'tanggal_akhir', name: 'tanggal_akhir' },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tablePengajuanInsentif').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/pengajuan/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'id', name: 'id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'pengajuan_untuk', name: 'pengajuan_untuk' },
            { data: 'judul', name: 'judul' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tablePengajuanInsentifDOI').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/doi/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'id', name: 'id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'str', name: 'str' },
            { data: 'jumlah_artikel', name: 'jumlah_artikel' },
            { data: 'status_pengajuan', name: 'status_pengajuan' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var tableInsentifReviewer = $('#tableInsentifReviewer').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/reviewer/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'hibah_id', name: 'hibah_id', orderable: false, searchable: false, visible: false },
            { data: 'hibah', name: 'hibah' },
            { data: 'tipe', name: 'tipe' },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'jumlah_usulan', name: 'jumlah_usulan' },
            { data: 'action', name: 'action' }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            }
        ]
    });

    $(document).on('change','#fTahun', function(){
        var val = $(this).val();
        if(val != ""){
            $.ajax({
                type: 'GET',
                url: '/insentif/reviewer/filter/'+val,
                dataType: 'json',
                success: function(data) {
                    if(data.length != 0){
                        $('#fHibah').empty();
                        $('#f_hibah').show();
                        $('#f_jenis').hide();
                        tableInsentifReviewer.ajax.url( '/insentif/reviewer/get/' ).load();
        
                        var str = '<option value="">--Pilih Hibah--</option>';
                        for(var i=0;i<data.length;i++){
                            var penyelenggara = data[i].fakultas_id != null ? 'LPPM' : 'Fakultas';
                            str += '<option value='+data[i].hibah_id+'>'+data[i].hibah_code+' - '+penyelenggara+' - '+data[i].tahun_pelaksanaan_hibah+'</option>';
                        }
        
                        $('#fHibah').append(str);
                    }
                }
            });
        }
        
        return false;
    });

    $(document).on('change','#fHibah', function(){
        var val = $(this).val();

        if(val != ""){
            $('#f_jenis').show();
            tableInsentifReviewer.ajax.url( '/insentif/reviewer/get/'+val ).load();
        }else{
            $('#f_jenis').hide();
            tableInsentifReviewer.ajax.url( '/insentif/reviewer/get/' ).load();
        }

        return false;
    });

    $(document).on('change','#fJenis', function(){
        var val = $(this).val();
        var hibahId = $('#fHibah option:selected').val();

        if(val != ""){
            tableInsentifReviewer.ajax.url( '/insentif/reviewer/get/'+hibahId+'/'+val ).load();
        }else{
            tableInsentifReviewer.ajax.url( '/insentif/reviewer/get/'+hibahId ).load();
        }

        return false;
    });

    $('#tablePengajuanInsentifPj').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/insentif/pengelola_jurnal/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'id', name: 'id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'str', name: 'str' },
            { data: 'jumlah_artikel', name: 'jumlah_artikel' },
            { data: 'status_pengajuan', name: 'status_pengajuan' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tablePublikasiJurnal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/publikasijurnal/getpublikasijurnal/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'publikasi_jurnal_id', name: 'publikasi_jurnal_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_personil', name: 'nama_personil' },
            { data: 'judul', name: 'judul' },
            { data: 'jenis_publikasi', name: 'jenis_publikasi' },
            { data: 'nama_jurnal', name: 'nama_jurnal' },
            { data: 'issn', name: 'issn' },
            { data: 'tingkat_jurnal', name: 'tingkat_jurnal' },
            {   
                data: 'berkas_publikasi_jurnal', 
                name: 'berkas_publikasi_jurnal',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/publikasi_ilmiah/" +row.berkas_publikasi_jurnal;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_publikasi_jurnal != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    if(row.url != null){
                        str += '<br><a href="'+row.url+'" target="_blank">URL Jurnal</a>';
                    }
                    if (row.url == 0){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == '-'){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == ''){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == undefined){
                        str += "<br><p style='text-align: center;'>-";
                    } 

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tablePublikasiJurnalEksternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/publikasijurnal/getpubjurnaleks/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'publikasi_jurnal_id', name: 'publikasi_jurnal_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_personil', name: 'nama_personil' },
            { data: 'judul', name: 'judul' },
            { data: 'jenis_publikasi', name: 'jenis_publikasi' },
            { data: 'nama_jurnal', name: 'nama_jurnal' },
            { data: 'issn', name: 'issn' },
            { data: 'tingkat_jurnal', name: 'tingkat_jurnal' },
            {   
                data: 'berkas_publikasi_jurnal', 
                name: 'berkas_publikasi_jurnal',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/publikasi_ilmiah/" +row.berkas_publikasi_jurnal;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_publikasi_jurnal != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    if(row.url != null){
                        str += '<br><a href="'+row.url+'" target="_blank">URL Jurnal</a>';
                    }
                    if (row.url == 0){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == '-'){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == ''){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == undefined){
                        str += "<br><p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });
    
    $('#tablePublikasiJurnalPengmas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/publikasijurnal_abdimas/getpublikasijurnal/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'publikasi_jurnal_id', name: 'publikasi_jurnal_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_personil', name: 'nama_personil' },
            { data: 'judul', name: 'judul' },
            { data: 'jenis_publikasi', name: 'jenis_publikasi' },
            { data: 'nama_jurnal', name: 'nama_jurnal' },
            { data: 'issn', name: 'issn' },
            { data: 'tingkat_jurnal', name: 'tingkat_jurnal' },
            {   
                data: 'berkas_publikasi_jurnal', 
                name: 'berkas_publikasi_jurnal',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/publikasi_ilmiah/" +row.berkas_publikasi_jurnal;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_publikasi_jurnal != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    if(row.url != null){
                        str += '<br><a href="'+row.url+'" target="_blank">URL Jurnal</a>';
                    }
                    if (row.url == 0){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == '-'){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == ''){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == undefined){
                        str += "<br><p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tablePublikasiJurnalPengmasEksternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/publikasijurnal_abdimas/getpubjurnaleks/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'publikasi_jurnal_id', name: 'publikasi_jurnal_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_personil', name: 'nama_personil' },
            { data: 'judul', name: 'judul' },
            { data: 'jenis_publikasi', name: 'jenis_publikasi' },
            { data: 'nama_jurnal', name: 'nama_jurnal' },
            { data: 'issn', name: 'issn' },
            { data: 'tingkat_jurnal', name: 'tingkat_jurnal' },
            {   
                data: 'berkas_publikasi_jurnal', 
                name: 'berkas_publikasi_jurnal',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/publikasi_ilmiah/" +row.berkas_publikasi_jurnal;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_publikasi_jurnal != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    if(row.url != null){
                        str += '<br><a href="'+row.url+'" target="_blank">URL Jurnal</a>';
                    }
                    if (row.url == 0){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == '-'){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == ''){
                        str += "<br><p style='text-align: center;'>-";
                    }
                    if (row.url == undefined){
                        str += "<br><p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableBukuAjar').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/bukuajar/getbukuajar/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'buku_ajar_id', name: 'buku_ajar_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_buku', name: 'judul_buku' },
            { data: 'isbn', name: 'isbn', 'width': '15%' },
            { data: 'jml_halaman', name: 'jml_halaman', 'width': '5%'},
            { data: 'penerbit', name: 'penerbit' },
            {   
                data: 'file_buku', 
                name: 'file_buku',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/buku_ajar/" +row.file_buku;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.file_buku != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun', orderable: false, visible: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    $('#tableBukuAjarPengmas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/bukuajar_abdimas/getbukuajar',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'buku_ajar_id', name: 'buku_ajar_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_buku', name: 'judul_buku' },
            { data: 'isbn', name: 'isbn' },
            { data: 'jml_halaman', name: 'jml_halaman' },
            { data: 'penerbit', name: 'penerbit' },
            {   
                data: 'file_buku', 
                name: 'file_buku',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/buku_ajar/" +row.file_buku;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.file_buku != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun', orderable: false, visible: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    $('#tableHKI').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/hki/gethki/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'hki_id', name: 'hki_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            {   
                data: 'no_hki', 
                name: 'no_hki',
                render: function(data, type, row) {
                    if(row.no_hki != null){
                        var str = row.no_hki;
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'judul_hki', name: 'judul_hki' },
            { data: 'status_hki', name: 'status_hki' },
            {   
                data: 'file_hki', 
                name: 'file_hki',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/hki/" +row.file_hki;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.file_hki != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    if(row.url_hki != null){
                        str += '<br><a href="'+row.url_hki+'" target="_blank">URL HKI</a>';
                    } else {
                        str += "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun', orderable: false, searchable: false, visible: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableHKIEksternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/hki/gethkieksternal/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'hki_id', name: 'hki_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            {   
                data: 'no_hki', 
                name: 'no_hki',
                render: function(data, type, row) {
                    if(row.no_hki != null){
                        var str = row.no_hki;
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'judul_hki', name: 'judul_hki' },
            { data: 'status_hki', name: 'status_hki' },
            {   
                data: 'file_hki', 
                name: 'file_hki',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/hki/" +row.file_hki;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.file_hki != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    if(row.url_hki != null){
                        str += '<br><a href="'+row.url_hki+'" target="_blank">URL HKI</a>';
                    } else {
                        str += "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun', orderable: false, searchable: false, visible: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });
    
    $('#tableHKIPengmas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/hki_abdimas/gethki/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'hki_id', name: 'hki_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'no_hki', name: 'no_hki' },
            { data: 'judul_hki', name: 'judul_hki' },
            { data: 'status_hki', name: 'status_hki' },
            {   
                data: 'file_hki', 
                name: 'file_hki',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/hki/" +row.file_hki;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.file_hki != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    if(row.url_hki != null){
                        str += '<br><a href="'+row.url_hki+'" target="_blank">URL HKI</a>';
                    } else {
                        str += "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun', orderable: false, searchable: false, visible: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableHKIPengmasEksternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/hki_abdimas/gethkieksternal/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'hki_id', name: 'hki_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'no_hki', name: 'no_hki' },
            { data: 'judul_hki', name: 'judul_hki' },
            { data: 'status_hki', name: 'status_hki' },
            {   
                data: 'file_hki', 
                name: 'file_hki',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/hki/" +row.file_hki;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.file_hki != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    if(row.url_hki != null){
                        str += '<br><a href="'+row.url_hki+'" target="_blank">URL HKI</a>';
                    } else {
                        str += "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'tahun', name: 'tahun', orderable: false, searchable: false, visible: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tablePemakalah').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/pemakalah/getpemakalah/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pemakalah_id', name: 'pemakalah_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_makalah', name: 'judul_makalah' },
            { data: 'nama_forum', name: 'nama_forum' },
            {
                data: 'tanggal_pelaksanaan',
                render: function(data, type, row) {
                    return row.tanggal_mulai_pelaksanaan + ' s.d ' + row.tanggal_akhir_pelaksanaan;
                }
            },
            { data: 'status_pemakalah', name: 'status_pemakalah' },
            {   
                data: 'berkas_pemakalah', 
                name: 'berkas_pemakalah',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/pemakalah_forum_ilmiah/" +row.berkas_pemakalah;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_pemakalah != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'jenis_forum', name: 'jenis_forum' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    $('#tablePemakalahEksternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/pemakalah/getpemakalaheksternal/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pemakalah_id', name: 'pemakalah_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_makalah', name: 'judul_makalah' },
            { data: 'nama_forum', name: 'nama_forum' },
            {
                data: 'tanggal_pelaksanaan',
                render: function(data, type, row) {
                    return row.tanggal_mulai_pelaksanaan + ' s.d ' + row.tanggal_akhir_pelaksanaan;
                }
            },
            { data: 'status_pemakalah', name: 'status_pemakalah' },
            {   
                data: 'berkas_pemakalah', 
                name: 'berkas_pemakalah',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/pemakalah_forum_ilmiah/" +row.berkas_pemakalah;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_pemakalah != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'jenis_forum', name: 'jenis_forum' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });
    
    $('#tablePemakalahPengmas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/pemakalah_abdimas/getpemakalah/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pemakalah_id', name: 'pemakalah_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_makalah', name: 'judul_makalah' },
            { data: 'nama_forum', name: 'nama_forum' },
            {
                data: 'tanggal_pelaksanaan',
                render: function(data, type, row) {
                    return row.tanggal_mulai_pelaksanaan + ' s.d ' + row.tanggal_akhir_pelaksanaan;
                }
            },
            { data: 'status_pemakalah', name: 'status_pemakalah' },
            {   
                data: 'berkas_pemakalah', 
                name: 'berkas_pemakalah',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/pemakalah_forum_ilmiah/" +row.berkas_pemakalah;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_pemakalah != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'jenis_forum', name: 'jenis_forum' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    $('#tablePemakalahPengmasEksternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/pemakalah_abdimas/getpemakalaheksternal/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'pemakalah_id', name: 'pemakalah_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_makalah', name: 'judul_makalah' },
            { data: 'nama_forum', name: 'nama_forum' },
            {
                data: 'tanggal_pelaksanaan',
                render: function(data, type, row) {
                    return row.tanggal_mulai_pelaksanaan + ' s.d ' + row.tanggal_akhir_pelaksanaan;
                }
            },
            { data: 'status_pemakalah', name: 'status_pemakalah' },
            {   
                data: 'berkas_pemakalah', 
                name: 'berkas_pemakalah',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/pemakalah_forum_ilmiah/" +row.berkas_pemakalah;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_pemakalah != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'jenis_forum', name: 'jenis_forum' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    $('#tableLuaranlain').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/luaranlain/getluaranlain/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'luaran_lainnya_id', name: 'luaran_lainnya_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_luaran', name: 'judul_luaran' },
            { data: 'jenis_luaran', name: 'jenis_luaran' },
            { data: 'jenis_luaran_lainnya', name: 'jenis_luaran_lainnya' },
            {   
                data: 'berkas_luaran_lainnya', 
                name: 'berkas_luaran_lainnya',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/luaran_lainnya/" +row.berkas_luaran_lainnya;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_luaran_lainnya != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    $('#tableLuaranlainEksterbal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/penelitian/luaranlain/getluaranlainEksternal/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'luaran_lainnya_id', name: 'luaran_lainnya_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_luaran', name: 'judul_luaran' },
            { data: 'jenis_luaran', name: 'jenis_luaran' },
            { data: 'jenis_luaran_lainnya', name: 'jenis_luaran_lainnya' },
            {   
                data: 'berkas_luaran_lainnya', 
                name: 'berkas_luaran_lainnya',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/luaran_lainnya/" +row.berkas_luaran_lainnya;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_luaran_lainnya != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });
    
    $('#tableLuaranlainPengmas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/luaranlain_abdimas/getluaranlain/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'luaran_lainnya_id', name: 'luaran_lainnya_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_luaran', name: 'judul_luaran' },
            { data: 'jenis_luaran', name: 'jenis_luaran' },
            { data: 'jenis_luaran_lainnya', name: 'jenis_luaran_lainnya' },
            {   
                data: 'berkas_luaran_lainnya', 
                name: 'berkas_luaran_lainnya',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/luaran_lainnya/" +row.berkas_luaran_lainnya;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_luaran_lainnya != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    $('#tableLuaranlainPengmasEksternal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/luaranlain_abdimas/getluaranlainEksternal/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'luaran_lainnya_id', name: 'luaran_lainnya_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_luaran', name: 'judul_luaran' },
            { data: 'jenis_luaran', name: 'jenis_luaran' },
            { data: 'jenis_luaran_lainnya', name: 'jenis_luaran_lainnya' },
            {   
                data: 'berkas_luaran_lainnya', 
                name: 'berkas_luaran_lainnya',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/luaran_lainnya/" +row.berkas_luaran_lainnya;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.berkas_luaran_lainnya != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5, 6, 7]
                }
            }
        ]
    });

    var rows_selected = [];

    var tableExistingAdminLppm = $('#tableExistingAdminLppm').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/admin_lppm/get_existing_admin_lppm',
        columns: [
            { data: 'action', width: "5%", name: 'action', orderable: false, searchable: false },
            { data: 'DT_RowIndex', width: "5%", name: 'DT_RowIndex' },
            { data: 'nama_lengkap', width: "90%", name: 'nama_lengkap' }
        ],
        'rowCallback': function(row, data, dataIndex){
            // Get row ID
            var rowId = data.user_id;
            
            // If row ID is in the list of selected row IDs
            if($.inArray(rowId, rows_selected) !== -1){
               $(row).find('input[type="checkbox"]').prop('checked', true);
            //    $(row).addClass('selected');
            }
         }
    });
    
    $('#tableExistingAdminLppm tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');
  
        // Get row data
        var data = tableExistingAdminLppm.row($row).data();
  
        // Get row ID
        var rowId = data.user_id;
  
        // Determine whether row ID is in the list of selected row IDs 
        var index = $.inArray(rowId, rows_selected);
  
        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
           rows_selected.push(rowId);
  
        // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
           rows_selected.splice(index, 1);
        }
  
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    var tableSetRoleAdminFakultas = $('#tableSetRoleAdminFakultas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/admin_fakultas/setrole',
        columns: [
            { data: 'action', width: "5%", name: 'action', orderable: false, searchable: false },
            { data: 'DT_RowIndex', width: "5%", name: 'DT_RowIndex' },
            { data: 'nama_lengkap', width: "90%", name: 'nama_lengkap' }
        ],
        'rowCallback': function(row, data, dataIndex){
            // Get row ID
            var rowId = data.user_id;
            
            // If row ID is in the list of selected row IDs
            if($.inArray(rowId, rows_selected) !== -1){
               $(row).find('input[type="checkbox"]').prop('checked', true);
            //    $(row).addClass('selected');
            }
         }
    });

    $('#tableSetRoleAdminFakultas tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');
  
        // Get row data
        var data = tableSetRoleAdminFakultas.row($row).data();
  
        // Get row ID
        var rowId = data.user_id;
  
        // Determine whether row ID is in the list of selected row IDs 
        var index = $.inArray(rowId, rows_selected);
  
        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
           rows_selected.push(rowId);
  
        // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
           rows_selected.splice(index, 1);
        }
  
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });
    
    $('#tableDataDosen').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/dosen/getall',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'dosen_id', name: 'dosen_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });
    
    $('#tableJurnal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/jurnal/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'jurnal_id', name: 'jurnal_id', orderable: false, searchable: false, visible: false },
            { data: 'nama', name: 'nama' },
            { data: 'issn', name: 'issn' },
            { data: 'tingkat_jurnal', name: 'tingkat_jurnal' },
            { data: 'akreditasi', name: 'akreditasi' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0,2,3,4,5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4,5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4,5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4,5]
                }
            }
        ]
    });
    $('#tableDataPengelolaJurnal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/pengelola_jurnal/get',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'dosen_id', name: 'dosen_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'nama_jurnal', name: 'nama_jurnal' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            }
        ]
    });

    $('#tableKuesioner').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/kuesioner/getall',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            { data: 'hibah', name: 'hibah' },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'judul_proposal', name: 'judul_proposal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [0,2,3,4]
                }
            }
        ]
    });

    $('#tableDataListDosen').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/dosen/getall',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'dosen_id', name: 'dosen_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var tableExistingDosen = $('#tableExistingDosen').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/dosen/setrole',
        columns: [
            { data: 'action', width: "5%", name: 'action', orderable: false, searchable: false },
            { data: 'DT_RowIndex', width: "5%", name: 'DT_RowIndex' },
            { data: 'nama_lengkap', width: "90%", name: 'nama_lengkap' }
        ],
        'rowCallback': function(row, data, dataIndex){
            // Get row ID
            var rowId = data.user_id;
            
            // If row ID is in the list of selected row IDs
            if($.inArray(rowId, rows_selected) !== -1){
               $(row).find('input[type="checkbox"]').prop('checked', true);
            //    $(row).addClass('selected');
            }
         }
    });
    
    $('#tableExistingDosen tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');
  
        // Get row data
        var data = tableExistingDosen.row($row).data();
  
        // Get row ID
        var rowId = data.user_id;
  
        // Determine whether row ID is in the list of selected row IDs 
        var index = $.inArray(rowId, rows_selected);
  
        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
           rows_selected.push(rowId);
  
        // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
           rows_selected.splice(index, 1);
        }
  
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    $('#tableDataReviewerLppm').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/reviewer_lppm/getall',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'user_id', name: 'user_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var tableExistingReviewerLppm = $('#tableExistingReviewerLppm').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/reviewer_lppm/setrole',
        columns: [
            { data: 'action', width: "5%", name: 'action', orderable: false, searchable: false },
            { data: 'DT_RowIndex', width: "5%", name: 'DT_RowIndex' },
            { data: 'nama_lengkap', width: "90%", name: 'nama_lengkap' }
        ]
    });

    $('#tableExistingReviewerLppm tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');
  
        // Get row data
        var data = tableExistingReviewerLppm.row($row).data();
  
        // Get row ID
        var rowId = data.user_id;
  
        // Determine whether row ID is in the list of selected row IDs 
        var index = $.inArray(rowId, rows_selected);
  
        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
           rows_selected.push(rowId);
  
        // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
           rows_selected.splice(index, 1);
        }
  
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    $('#tableDatareviewerFakultas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/reviewer_fakultas/getall',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'user_id', name: 'user_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var tableExistingReviewerFakultas = $('#tableExistingReviewerFakultas').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/setting/reviewer_fakultas/setrole',
        columns: [
            { data: 'action', width: "5%", name: 'action', orderable: false, searchable: false },
            { data: 'DT_RowIndex', width: "5%", name: 'DT_RowIndex' },
            { data: 'nama_lengkap', width: "90%", name: 'nama_lengkap' }
        ],
        'rowCallback': function(row, data, dataIndex){
            // Get row ID
            var rowId = data.user_id;
            
            // If row ID is in the list of selected row IDs
            if($.inArray(rowId, rows_selected) !== -1){
               $(row).find('input[type="checkbox"]').prop('checked', true);
            //    $(row).addClass('selected');
            }
         }
    });

    $('#tableExistingReviewerFakultas tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');
  
        // Get row data
        var data = tableExistingReviewerFakultas.row($row).data();
  
        // Get row ID
        var rowId = data.user_id;
  
        // Determine whether row ID is in the list of selected row IDs 
        var index = $.inArray(rowId, rows_selected);
  
        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
           rows_selected.push(rowId);
  
        // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
           rows_selected.splice(index, 1);
        }
  
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    
    $(document).on("click", "#button_set_role", function(e) {
        // var count = $("input:checked", tableExistingReviewerFakultas.fnGetNodes()).length;
        // console.log(rows_selected.length);

        if (rows_selected.length == 0) {
            swal({
                title: "Warning",
                text: "Please select before set role!",
                type: "warning",
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Okay, got it!",
                closeOnConfirm: true
            })
            $('#add_existing_data').modal('hide');
        } else {
            $('#add_existing_data').modal('show');
            var data = $('input[name="selected[]"]:checked');
            var data_srlz = data.serializeArray();
            var value = [];

            for (var i = 0; i < rows_selected.length; ++i) {
                value[i] = rows_selected[i];
            }

            document.getElementById('roles').value = value;
        }

        e.preventDefault();
    });

    $('#tableMedia').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/media/getmedia',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'media_id', name: 'media_id', orderable: false, searchable: false, visible: false },
            { data: 'judul', name: 'judul' },
            { data: 'jenis_media', name: 'jenis_media' },
            { data: 'jenis_media_massa', 
                render: function(data, type, row) {
                    var jenis_media_massa;

                    if(row.jenis_media_massa == null){
                        jenis_media_massa = '-';
                    } else {
                        jenis_media_massa = row.jenis_media_massa;
                    }
                    return jenis_media_massa;
                } 
            },
            { data: 'url_media', name: 'url_media' },
            {   
                data: 'file_media', 
                name: 'file_media',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/media/" +row.file_media;
                    var baseUrlImg = baseUrl + "/" + val;
                    if(row.file_media != null){
                        var str ='<a href="'+baseUrlImg+'" target="_blank">Download</a>';
                    } else {
                        var str = "<p style='text-align: center;'>-";
                    }

                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableDataListPenelitiAsing').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/sumber_daya/penelitian/peneliti_asing/getall',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'dosen_id', name: 'dosen_id', orderable: false, searchable: false, visible: false },
            { data: 'nidn', name: 'nidn' },
            { data: 'nama_dosen', name: 'nama_dosen' },
            { data: 'nama_fakultas', name: 'nama_fakultas' },
            { data: 'nama_prodi', name: 'nama_prodi' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    $('#tableDataListStafPendukung').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/sumber_daya/penelitian/staf_pendukung/getall/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'staf_pendukung_id', name: 'staf_pendukung_id', orderable: false, searchable: false, visible: false },
            { data: 'nip_nik', name: 'nip_nik' },
            {
                data: 'nama_lengkap',
                render: function(data, type, row) {
                    var gelar_depan = row.gelar_depan;
                    var gelar_belakang = row.gelar_belakang;

                    if(gelar_depan == null || gelar_depan == undefined){
                        gelar_depan = '';
                    }
                    if(gelar_belakang == null || gelar_belakang == undefined){
                        gelar_belakang = '';
                    }

                return gelar_depan + ' ' + row.nama_lengkap+ ' ' + gelar_belakang;
            } },
            {
                data: 'nama_fakultas',
                render: function(data, type, row) {
                    var nama_fakultas;

                    if(row.nama_fakultas == null){
                        nama_fakultas = '<p style="text-align: center;">-</p>';
                    } else {
                        nama_fakultas = row.nama_fakultas;
                    }
                    return nama_fakultas;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });
    
    $('#tableProduk').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/produk/getproduk/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'produk_id', name: 'produk_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_produk',
                render: function(data, type, row) {
                    var str = '<b>Dosen</b> : '+row.dosen +'<br><b>Alamat Mitra</b> : '+row.alamat_mitra; //+ '<br><b>Mahasiswa</b> : ' + row.mahasiswa
                    return str;
                }
            },
            {
                data: 'nama_produk',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    if(row.jenis_produk == "Terstandarisasi"){
                        var val = "upload/produk/" +row.file_standarisasi;
                    } else {
                        var val = "upload/produk/" +row.file_sertifikat;
                    }
                    var baseUrlImg = baseUrl + "/" + val;

                    
                    if(row.file_standarisasi !== null || row.file_sertifikat !== null){
                        var file = '<a href="'+baseUrlImg+'" class="btn btn-icon" title="Download Dokumen" target="_blank">Download Dokumen</a>';
                    } else {
                        var file = '-';
                    }

                    if(row.lembaga_pemberi != null){
                        var lembaga_pemberi = row.lembaga_pemberi;
                    } else {
                        var lembaga_pemberi = "-";
                    }

                    var str = '<b>Nama Produk</b> : '+row.nama_produk + '<br><b>Dokumen</b> : ' + file +'<br><b>Lembaga Pemberi</b> : '+lembaga_pemberi;
                    return str;
                }
            },
            { data: 'keterangan_uraian', name: 'keterangan_uraian' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });
    
    $('#tableMitraHukum').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/mitra_hukum/getmitrahukum/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'mitra_berbadan_hukum_id', name: 'mitra_berbadan_hukum_id', orderable: false, searchable: false, visible: false },
            {
                data: 'nama_tim',
                render: function(data, type, row) {
                    var str = '<b>Dosen</b> : '+row.dosen + '<br>';
                    if(row.mahasiswa != null){
                        str += '<b>Mahasiswa</b> : ' + row.mahasiswa+'<br><b>Alamat Mitra</b> : '+row.alamat_mitra;    
                    }

                    return str;
                }
            },
            {
                data: 'nama_mitra',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/mitra_hukum/" +row.file_keputusan_berbadan_hukum;
                    var baseUrlImg = baseUrl + "/" + val;

                    
                    if(row.file_keputusan_berbadan_hukum !== null){
                        var file = '<a href="'+baseUrlImg+'" class="btn btn-icon" title="Download Dokumen" target="_blank">Download Dokumen</a>';
                    } else {
                        var file = '-';
                    }

                    var str = '<b>Nama Mitra</b> : '+row.nama_mitra + '<br><b>Dokumen</b> : ' + file +'<br><b>Lembaga Pemberi</b> : '+row.lembaga_pemberi_status;
                    return str;
                }
            },
            { data: 'keterangan_uraian', name: 'keterangan_uraian' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });
    
    $('#tableWiraUsaha').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/luaran/pengmas/wira_usaha/getwirausaha/'+window.localStorage['filter_tahun'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'wirausaha_mandiri_id', name: 'wirausaha_mandiri_id', orderable: false, searchable: false, visible: false },
            { data: 'nama_wirausaha', name: 'nama_wirausaha' },
            { data: 'jenis_usaha', name: 'jenis_usaha' },
            {
                data: 'file',
                render: function(data, type, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl.protocol + "//" + getUrl.host;
                    var val = "upload/wira_usaha/" +row.file;
                    var baseUrlImg = baseUrl + "/" + val;
                    var str = '<a href="'+baseUrlImg+'" class="btn btn-icon" title="Unduh Dokumen" target="_blank">Download Dokumen</a>';

                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        },
        dom: 'lBfrtip',
        buttons: [{
                "extend": 'pdfHtml5',
                "text": 'Export PDF',
                "download": 'open', //open new tab
                "className": 'btn btn-info btn-xs ml-10',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'copyHtml5',
                "text": 'Copy Table',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'excelHtml5',
                "text": 'Export Excel',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            },
            {
                "extend": 'csvHtml5',
                "text": 'Export CSV',
                "className": 'btn btn-info btn-xs',
                "exportOptions": {
                    columns: [2, 3, 4, 5]
                }
            }
        ]
    });

    var tablePelaksanaanCatatan = $('#tablePelaksanaanCatatan').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pelaksanaan_kegiatan/catatan_harian/getcatatanharian',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'proposal_id', name: 'proposal_id', orderable: false, searchable: false, visible: false },
            {
                data: 'jenis_program',
                name: 'hibah.jenis_program',
                render: function(data, type, row) {
                    var str = row.jenis_hibah+' - '+ row.jenis_program + '<br>Tahun ' + row.tahun_pelaksanaan_hibah;
                    return str;
                }
            },
            { data: 'judul_proposal', name: 'judul_proposal' },
            {
                data: 'nama_anggota',
                render: function(data, type, row) {
                    var a = null;
                    var str = '';
                    row.nama_anggota = row.nama_anggota.substring(0,row.nama_anggota.length-1);
                    a = row.nama_anggota.split(';');
                    for (var i = 0; i < a.length; i++) {
                        str += (i + 1) + '. ' + a[i] + '<br>';
                    }
                    return str;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            searchPlaceholder: "Search records"
        }
    });
    
    $(document).on('change','#filterHibahPelaksanaan2', function(){
        if($(this).val() == ""){
            tableLaporanAkhir.ajax.url( '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir' ).load();
        }
    });

    $(document).on('change','#filterHibahOption2', function(){
        var val=$(this).val().split('|')
        tableLaporanAkhir.ajax.url( '/pelaksanaan_kegiatan/laporan_akhir/getlaporanakhir/'+val[0]+'/'+val[1] ).load();

        // if(+$(this).val() == ""){
        //     $("#catatan_harian").hide();
        // }
    });
    

    //force add margin top
    $('#tableMonevAllCatatan_wrapper').css("margin-top", "20px");
    $('#tableContact_wrapper').css("margin-top", "20px");
    $('#tableMonevAllPoster_wrapper').css("margin-top", "20px");
    $('#tableMonevAllPemakalah_wrapper').css("margin-top", "20px");
    $('#tableMonevAllPublikasi_wrapper').css("margin-top", "20px");
    $('#tableMonevAllLuaranLainnya_wrapper').css("margin-top", "20px");
    $('#tableMonevAllLaporanAkhir_wrapper').css("margin-top", "20px");
    $('#tableMonevCatatanPenelitian_wrapper').css("margin-top", "20px");
    $('#tableMonevCatatanAbdimas_wrapper').css("margin-top", "20px");
    $('#tableMonevLaporanLuaran_wrapper').css("margin-top", "20px");
    $('#tableMonevLaporanAkhir_wrapper').css("margin-top", "20px");
    $('#tableCatatanHarian_wrapper').css("margin-top", "20px");
    $('#tableRiwayatPenelitian_wrapper').css("margin-top", "20px");
    $('#tableRiwayatAbdimas_wrapper').css("margin-top", "20px");
    $('#tableMonevPenelitian_wrapper').css("margin-top", "20px");
    $('#tableMonevAbdimas_wrapper').css("margin-top", "20px");
    $('#tablePemakalah_wrapper').css("margin-top", "20px");
    $('#tablePemakalahEksternal_wrapper').css("margin-top", "20px");
    $('#tablePemakalahPengmas_wrapper').css("margin-top", "20px");
    $('#tablePemakalahPengmasEksternal_wrapper').css("margin-top", "20px");
    $('#tableHKI_wrapper').css("margin-top", "20px");
    $('#tableHKIEksternal_wrapper').css("margin-top", "20px");
    $('#tableInsentifReviewer_wrapper').css("margin-top", "20px");
    $('#tableHKIPengmas_wrapper').css("margin-top", "20px");
    $('#tableHKIPengmasEksternal_wrapper').css("margin-top", "20px");
    $('#tableBukuAjar_wrapper').css("margin-top", "20px");
    $('#tableFakultas_wrapper').css("margin-top", "20px");
    $('#tableBukuAjarPengmas_wrapper').css("margin-top", "20px");
    $('#tableUnitFasilitas_wrapper').css("margin-top", "20px");
    $('#tablePublikasiJurnal_wrapper').css("margin-top", "20px");
    $('#tablePeriodeInsentif_wrapper').css("margin-top", "20px");
    $('#tablePengajuanInsentif_wrapper').css("margin-top", "20px");
    $('#tablePengajuanInsentifDOI_wrapper').css("margin-top", "20px");
    $('#tablePengajuanInsentifPj_wrapper').css("margin-top", "20px");
    $('#tablePublikasiJurnalEksternal_wrapper').css("margin-top", "20px");
    $('#tablePublikasiJurnalPengmas_wrapper').css("margin-top", "20px");
    $('#tablePublikasiJurnalPengmasEksternal_wrapper').css("margin-top", "20px");
    $('#tableForumIlmiah_wrapper').css("margin-top", "20px");
    $('#tableExistingAdminLppm_wrapper').css("margin-top", "20px");
    $('#tableDataAdminLppm_wrapper').css("margin-top", "20px");
    $('#tableHibahInternal_wrapper').css("margin-top", "20px");
    $('#tableHibahEksternal_wrapper').css("margin-top", "20px");
    $('#tableHibahInternalAbdimas_wrapper').css("margin-top", "20px");
    $('#tableHibahEksternalAbdimas_wrapper').css("margin-top", "20px");
    $('#tableDataAdminFakultas_wrapper').css("margin-top", "20px");
    $('#tablePengajuanInsentifDashboard_wrapper').css("margin-top", "20px");
    $('#tablePengajuanInsentifDOIDashboard_wrapper').css("margin-top", "20px");
    $('#tablePengajuanInsentifPjDashboard_wrapper').css("margin-top", "20px");
    $('#tablePengajuanInsentifHKI_wrapper').css("margin-top", "20px");
    $('#tableSetRoleAdminFakultas_wrapper').css("margin-top", "20px");
    $('#tableDataDosen_wrapper').css("margin-top", "20px");
    $('#tableDataPengelolaJurnal_wrapper').css("margin-top", "20px");
    $('#tableDataListDosen_wrapper').css("margin-top", "20px");
    $('#tableExistingDosen_wrapper').css("margin-top", "20px");
    $('#tableDataReviewerLppm_wrapper').css("margin-top", "20px");
    $('#tableExistingReviewerLppm_wrapper').css("margin-top", "20px");
    $('#tableDatareviewerFakultas_wrapper').css("margin-top", "20px");
    $('#tableExistingReviewerFakultas_wrapper').css("margin-top", "20px");
    $('#tableLuaranlain_wrapper').css("margin-top", "20px");
    $('#tableLuaranlainEksterbal_wrapper').css("margin-top", "20px");
    $('#tableLuaranlainPengmas_wrapper').css("margin-top", "20px");
    $('#tableLuaranlainPengmasEksternal_wrapper').css("margin-top", "20px");
    $('#tableMedia_wrapper').css("margin-top", "20px");
    $('#tableDataListPenelitiAsing_wrapper').css("margin-top", "20px");
    $('#tableDataListStafPendukung_wrapper').css("margin-top", "20px");
    $('#tableUnitBisnis_wrapper').css("margin-top", "20px");
    $('#tableKontrakKerja_wrapper').css("margin-top", "20px");
    $('#tableProduk_wrapper').css("margin-top", "20px");
    $('#tableMitraHukum_wrapper').css("margin-top", "20px");
    $('#tableWiraUsaha_wrapper').css("margin-top", "20px");
    $('#tableLaporanJurnal_wrapper').css("margin-top", "20px");
    $('#tableLaporanPemakalah_wrapper').css("margin-top", "20px");
    $('#tableLuaranPoster_wrapper').css("margin-top", "20px");
    $('#tableLaporanluaranLainnya_wrapper').css("margin-top", "20px");
    $('#tableKuesioner_wrapper').css("margin-top", "20px");
    $('#tableJurnal_wrapper').css("margin-top", "20px");

    $('.dt-buttons').css("margin-bottom", "10px");
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYear" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableForumIlmiah_wrapper #tableForumIlmiah_filter").insertBefore($('label:contains("Search")'));

    $('#filterYear').on('change', function() {
        $('#tableForumIlmiah').DataTable()
            .ajax.url(
                '/forumilmiah/getforumilmiah/' + $(this).val()
            )
            .load();
    });

    $('#tablePemakalah_wrapper #tablePemakalah_filter label').prop('id', 'searchPemakalah');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearPemakalah" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tablePemakalah_wrapper #tablePemakalah_filter").insertBefore($('#searchPemakalah'));

    $('#filterYearPemakalah').on('change', function() {
        $('#tablePemakalah').DataTable()
            .ajax.url(
                '/luaran/penelitian/pemakalah/getpemakalah/' + $(this).val()
            )
            .load();
    });

    $('#tablePemakalahEksternal_wrapper #tablePemakalahEksternal_filter label').prop('id', 'searchPemakalahEksternal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearPemakalahEks" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tablePemakalahEksternal_wrapper #tablePemakalahEksternal_filter").insertBefore($('#searchPemakalahEksternal'));

    $('#filterYearPemakalahEks').on('change', function() {
        $('#tablePemakalahEksternal').DataTable()
            .ajax.url(
                '/luaran/penelitian/pemakalah/getpemakalaheksternal/' + $(this).val()
            )
            .load();
    });
    
    $('#tablePemakalahPengmas_wrapper #tablePemakalahPengmas_filter label').prop('id', 'searchPemakalahPengmas');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearPemakalahPengmas" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tablePemakalahPengmas_wrapper #tablePemakalahPengmas_filter").insertBefore($('#searchPemakalahPengmas'));

    $('#filterYearPemakalahPengmas').on('change', function() {
        $('#tablePemakalahPengmas').DataTable()
            .ajax.url(
                '/luaran/pengmas/pemakalah_abdimas/getpemakalah/' + $(this).val()
            )
            .load();
    });

    $('#tablePemakalahPengmasEksternal_wrapper #tablePemakalahPengmasEksternal_filter label').prop('id', 'searchPemakalahPengmasEksternal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearPemakalahPengmasEksternal" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tablePemakalahPengmasEksternal_wrapper #tablePemakalahPengmasEksternal_filter").insertBefore($('#searchPemakalahPengmasEksternal'));

    $('#filterYearPemakalahPengmasEksternal').on('change', function() {
        $('#tablePemakalahPengmasEksternal').DataTable()
            .ajax.url(
                '/luaran/pengmas/pemakalah_abdimas/getpemakalaheksternal/' + $(this).val()
            )
            .load();
    });
    
    $('#tablePublikasiJurnal_wrapper #tablePublikasiJurnal_filter label').prop('id', 'searchPublikasiJurnal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearPublikasiJurnal" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tablePublikasiJurnal_wrapper #tablePublikasiJurnal_filter").insertBefore($('#searchPublikasiJurnal'));

    $('#filterYearPublikasiJurnal').on('change', function() {
        $('#tablePublikasiJurnal').DataTable()
            .ajax.url(
                '/luaran/penelitian/publikasijurnal/getpublikasijurnal/' + $(this).val()
            )
            .load();
    });

    $('#tablePublikasiJurnalEksternal_wrapper #tablePublikasiJurnalEksternal_filter label').prop('id', 'searchtablePublikasiJurnalEksternal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYeartablePublikasiJurnalEksternal" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tablePublikasiJurnalEksternal_wrapper #tablePublikasiJurnalEksternal_filter").insertBefore($('#searchtablePublikasiJurnalEksternal'));

    $('#filterYeartablePublikasiJurnalEksternal').on('change', function() {
        $('#tablePublikasiJurnalEksternal').DataTable()
            .ajax.url(
                '/luaran/penelitian/publikasijurnal/getpubjurnaleks/' + $(this).val()
            )
            .load();
    });
    
    // $('#tablePublikasiJurnalPengmas_wrapper #tablePublikasiJurnalPengmas_filter label').prop('id', 'searchPublikasiJurnalPerngmas');

    // $('<label class="ml-10">Filter by ' +
    //     '<select id="filterYearPublikasiJurnalPengmas" style="width:auto;" class="form-control input-sm">' +
    //     '<option value="">Pilih tahun</option>' +
    //     '<option value="2010" '+(window.localStorage['filter_tahun']=='2010' ? 'selected' : '')+'>2010</option>' +
    //     '<option value="2011" '+(window.localStorage['filter_tahun']=='2011' ? 'selected' : '')+'>2011</option>' +
    //     '<option value="2012" '+(window.localStorage['filter_tahun']=='2012' ? 'selected' : '')+'>2012</option>' +
    //     '<option value="2013" '+(window.localStorage['filter_tahun']=='2013' ? 'selected' : '')+'>2013</option>' +
    //     '<option value="2014" '+(window.localStorage['filter_tahun']=='2014' ? 'selected' : '')+'>2014</option>' +
    //     '<option value="2015" '+(window.localStorage['filter_tahun']=='2015' ? 'selected' : '')+'>2015</option>' +
    //     '<option value="2016" '+(window.localStorage['filter_tahun']=='2016' ? 'selected' : '')+'>2016</option>' +
    //     '<option value="2017" '+(window.localStorage['filter_tahun']=='2017' ? 'selected' : '')+'>2017</option>' +
    //     '<option value="2018" '+(window.localStorage['filter_tahun']=='2018' ? 'selected' : '')+'>2018</option>' +
    //     '<option value="2019" '+(window.localStorage['filter_tahun']=='2019' ? 'selected' : '')+'>2019</option>' +
    //     '<option value="2020" '+(window.localStorage['filter_tahun']=='2020' ? 'selected' : '')+'>2020</option>' +
    //     '</select>' +
    //     '</label>').appendTo("#tablePublikasiJurnalPengmas_wrapper #tablePublikasiJurnalPengmas_filter").insertBefore($('#searchPublikasiJurnalPerngmas'));

    // $('#filterYearPublikasiJurnalPengmas').on('change', function() {
    //     $('#tablePublikasiJurnalPengmas').DataTable()
    //         .ajax.url(
    //             '/luaran/pengmas/publikasijurnal_abdimas/getpublikasijurnal/' + $(this).val()
    //         )
    //         .load();
    // });

    $('#tablePublikasiJurnalPengmasEksternal_wrapper #tablePublikasiJurnalPengmasEksternal_filter label').prop('id', 'searchPublikasiJurnalPengmasEksternal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearPublikasiJurnalPengmasEksternal" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tablePublikasiJurnalPengmasEksternal_wrapper #tablePublikasiJurnalPengmasEksternal_filter").insertBefore($('#searchPublikasiJurnalPengmasEksternal'));

    $('#filterYearPublikasiJurnalPengmasEksternal').on('change', function() {
        $('#tablePublikasiJurnalPengmasEksternal').DataTable()
            .ajax.url(
                '/luaran/pengmas/publikasijurnal_abdimas/getpubjurnaleks/' + $(this).val()
            )
            .load();
    });
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearBuku" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableBukuAjar_wrapper #tableBukuAjar_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearBuku').on('change', function() {
        $('#tableBukuAjar').DataTable()
            .ajax.url(
                '/luaran/penelitian/bukuajar/getbukuajar/' + $(this).val()
            )
            .load();
    });
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearBukuPengmas" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableBukuAjarPengmas_wrapper #tableBukuAjarPengmas_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearBukuPengmas').on('change', function() {
        $('#tableBukuAjarPengmas').DataTable()
            .ajax.url(
                '/luaran/pengmas/bukuajar_abdimas/getbukuajar/' + $(this).val()
            )
            .load();
    });

    $('#tableHKI_wrapper #tableHKI_filter label').prop('id', 'searchHKI');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearHKI" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableHKI_wrapper #tableHKI_filter").insertBefore($('#searchHKI'));

    $('#filterYearHKI').on('change', function() {
        $('#tableHKI').DataTable()
            .ajax.url(
                '/luaran/penelitian/hki/gethki/' + $(this).val()
            )
            .load();
    });

    $('#tableHKIEksternal_wrapper #tableHKIEksternal_filter label').prop('id', 'searchHKIEksternal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearHKIEksternal" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>20'+i+'10</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableHKIEksternal_wrapper #tableHKIEksternal_filter").insertBefore($('#searchHKIEksternal'));

    $('#filterYearHKIEksternal').on('change', function() {
        $('#tableHKIEksternal').DataTable()
            .ajax.url(
                '/luaran/penelitian/hki/gethkieksternal/' + $(this).val()
            )
            .load();
    });
    
    $('#tableHKIPengmas_wrapper #tableHKIPengmas_filter label').prop('id', 'searchHKIPengmas');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearHKIAbdimas" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableHKIPengmas_wrapper #tableHKIPengmas_filter").insertBefore($('#searchHKIPengmas'));

    $('#filterYearHKIAbdimas').on('change', function() {
        $('#tableHKIPengmas').DataTable()
            .ajax.url(
                '/luaran/pengmas/hki_abdimas/gethki/' + $(this).val()
            )
            .load();
    });

    $('#tableHKIPengmasEksternal_wrapper #tableHKIPengmasEksternal_filter label').prop('id', 'searchHKIPengmasEksternal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearHKIPengmasEksternal" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableHKIPengmasEksternal_wrapper #tableHKIPengmasEksternal_filter").insertBefore($('#searchHKIPengmasEksternal'));

    $('#filterYearHKIPengmasEksternal').on('change', function() {
        $('#tableHKIPengmasEksternal').DataTable()
            .ajax.url(
                '/luaran/pengmas/hki_abdimas/gethkieksternal/' + $(this).val()
            )
            .load();
    });

    $('#tableLuaranlain_wrapper #tableLuaranlain_filter label').prop('id', 'searchLuaranlain');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearLuaranLain" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableLuaranlain_wrapper #tableLuaranlain_filter").insertBefore($('#searchLuaranlain'));

    $('#filterYearLuaranLain').on('change', function() {
        $('#tableLuaranlain').DataTable()
            .ajax.url(
                '/luaran/penelitian/luaranlain/getluaranlain/' + $(this).val()
            )
            .load();
    });

    $('#tableLuaranlainEksterbal_wrapper #tableLuaranlainEksterbal_filter label').prop('id', 'searchLuaranlainEksterbal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearsearchLuaranlainEksterbal" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableLuaranlainEksterbal_wrapper #tableLuaranlainEksterbal_filter").insertBefore($('#searchLuaranlainEksterbal'));

    $('#filterYearsearchLuaranlainEksterbal').on('change', function() {
        $('#tableLuaranlainEksterbal').DataTable()
            .ajax.url(
                '/luaran/penelitian/luaranlain/getluaranlainEksternal/' + $(this).val()
            )
            .load();
    });
    
    $('#tableLuaranlainPengmas_wrapper #tableLuaranlainPengmas_filter label').prop('id', 'searchtableLuaranlainPengmas');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYeartableLuaranlainPengmas" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableLuaranlainPengmas_wrapper #tableLuaranlainPengmas_filter").insertBefore($('#searchtableLuaranlainPengmas'));

    $('#filterYeartableLuaranlainPengmas').on('change', function() {
        $('#tableLuaranlainPengmas').DataTable()
            .ajax.url(
                '/luaran/pengmas/luaranlain_abdimas/getluaranlain/' + $(this).val()
            )
            .load();
    });

    $('#tableLuaranlainPengmasEksternal_wrapper #tableLuaranlainPengmasEksternal_filter label').prop('id', 'searchLuaranlainPengmasEksternal');
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearsearchLuaranlainPengmasEksternal" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableLuaranlainPengmasEksternal_wrapper #tableLuaranlainPengmasEksternal_filter").insertBefore($('#searchLuaranlainPengmasEksternal'));

    $('#filterYearsearchLuaranlainPengmasEksternal').on('change', function() {
        $('#tableLuaranlainPengmasEksternal').DataTable()
            .ajax.url(
                '/luaran/pengmas/luaranlain_abdimas/getluaranlainEksternal/' + $(this).val()
            )
            .load();
    });
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearFasilitas" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableUnitFasilitas_wrapper #tableUnitFasilitas_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearFasilitas').on('change', function() {
        $('#tableUnitFasilitas').DataTable()
            .ajax.url(
                '/unitfasilitas/getunitfasilitas/' + $(this).val()
            )
            .load();
    });
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearStafPendukung" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableDataListStafPendukung_wrapper #tableDataListStafPendukung_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearStafPendukung').on('change', function() {
        $('#tableDataListStafPendukung').DataTable()
            .ajax.url(
                '/sumber_daya/penelitian/staf_pendukung/getall/' + $(this).val()
            )
            .load();
    });

    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearUnitBisnis" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableUnitBisnis_wrapper #tableUnitBisnis_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearUnitBisnis').on('change', function() {
        $('#tableUnitBisnis').DataTable()
            .ajax.url(
                '/unitbisnishasilriset/getbisnisriset/' + $(this).val()
            )
            .load();
    });
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearKontrakKerja" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableKontrakKerja_wrapper #tableKontrakKerja_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearKontrakKerja').on('change', function() {
        $('#tableKontrakKerja').DataTable()
            .ajax.url(
                '/kontrakkerja/getkontrakkerja/' + $(this).val()
            )
            .load();
    });
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearProduk" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableProduk_wrapper #tableProduk_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearProduk').on('change', function() {
        $('#tableProduk').DataTable()
            .ajax.url(
                '/luaran/pengmas/produk/getproduk/' + $(this).val()
            )
            .load();
    });
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearMitraHukum" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableMitraHukum_wrapper #tableMitraHukum_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearMitraHukum').on('change', function() {
        $('#tableMitraHukum').DataTable()
            .ajax.url(
                '/luaran/pengmas/wira_usaha/getwirausaha/' + $(this).val()
            )
            .load();
    });
    
    var str = '<label class="ml-10">Filter by ' +
    '<select id="filterYearWiraUsaha" style="width:auto;" class="form-control input-sm">' +
    '<option value="">Pilih tahun</option>';
    var start_year = new Date().getFullYear();
    for(var i=start_year;i > start_year - 10; i--){
        str += '<option value="'+i+'" '+(window.localStorage['filter_tahun']==i ? 'selected' : '')+'>'+i+'</option>';    
    }
    str += '</select>' +
    '</label>';
    $(str).appendTo("#tableWiraUsaha_wrapper #tableWiraUsaha_filter").insertBefore($('label:contains("Search")'));

    $('#filterYearWiraUsaha').on('change', function() {
        $('#tableWiraUsaha').DataTable()
            .ajax.url(
                '/luaran/pengmas/wira_usaha/getwirausaha/' + $(this).val()
            )
            .load();
    });
});

//Jika size data table diganti
$(document).on('change', '.size', function() {
    var query = $('.searchdata').val();
    var column_name = $('.hidden_column_name').val();
    var sort_type = $('.hidden_sort_type').val();
    var page = $('.hidden_page').val();
    var tipeform = $('.tipe_form').val();

    var size = $('.size').val();
    fetch_data(page, sort_type, column_name, query, tipeform, size);
});

//Jika tombol sorting di header kolom diklik
$(document).on('click', '.sorting', function() {
    var column_name = $(this).data('column_name');
    var order_type = $(this).data('sorting_type');
    var reverse_order = '';
    if (order_type == 'asc') {
        $(this).data('sorting_type', 'desc');
        reverse_order = 'desc';
        clear_icon();
        $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
    }

    if (order_type == 'desc') {
        $(this).data('sorting_type', 'asc');
        reverse_order = 'asc';
        clear_icon
        $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
    }
    $('.hidden_column_name').val(column_name);
    $('.hidden_sort_type').val(reverse_order);
    var page = $('.hidden_page').val();
    var query = $('.searchdata').val();
    var tipeform = $('.tipe_form').val();
    var size = $('.size').val();
    fetch_data(page, reverse_order, column_name, query, tipeform, size);
});

$(document).ready(function() {
    $('#formUpload').submit(function(event) {
        event.preventDefault();
        console.info($(this)[0]);
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "File sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/hibah/penelitian/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.info(result);
                if (result.message.includes('invalid')) {
                    swal("Warning", result.message, "warning");
                } else if (result.message.includes('Success')) {
                    swal("Success", result.message, "success");
                } else {
                    swal("Warning", result.message, "warning");
                }
            },
            error: function(data) {
                console.log(data);
            }
        });

    });
});

$(document).ready(function() {
    $('#formUploadLaporanAkhir').submit(function(event) {
        event.preventDefault();
        console.info($(this)[0]);
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "Berkas sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/pelaksanaan_kegiatan/laporan_akhir/uploadlaporanakhir',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.info(result);
                if (result.message.includes('invalid')) {
                    swal("Warning", result.message, "warning");
                } else if (result.message.includes('Success')) {
                    swal({
                        'title':'Success',
                        'text':result.message,
                        'type':'success',
                    },function() {
                        $('#uploadfinalreport').modal('hide');
                        location.reload();
                    })
                } 
            },
            error: function(data) {
                swal("Error", data, "error");
            }
        });

    });

    $('#formUploadInsentif').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "Berkas sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/insentif/pengajuan/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.info(result);
                if (result.message.includes('invalid')) {
                    swal("Warning", result.message, "warning");
                } else if (result.message.includes('Success')) {
                    swal({
                        'title':'Success',
                        'text':result.message,
                        'type':'success',
                    },function() {
                        $('#upload_insentif').modal('hide');
                        location.reload();
                    })
                } 
            },
            error: function(data) {
                swal("Error", data, "error");
            }
        });

    });

    $('#formUploadSertifikat').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "Berkas sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/insentif/pengajuan/upload/hki',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.info(result);
                if (result.message.includes('invalid')) {
                    swal("Warning", result.message, "warning");
                } else if (result.message.includes('Success')) {
                    swal({
                        'title':'Success',
                        'text':result.message,
                        'type':'success',
                    },function() {
                        $('#upload_insentif').modal('hide');
                        location.reload();
                    })
                } 
            },
            error: function(data) {
                swal("Error", data, "error");
            }
        });

    });
});

$(document).ready(function() {
    $('#formUploadPoster').submit(function(event) {
        event.preventDefault();
        console.info($(this)[0]);
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "Berkas sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/pelaksanaan_kegiatan/laporan_luaran/uploadposter',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.info(result);
                if (result.message.includes('invalid')) {
                    swal("Warning", result.message, "warning");
                } else if (result.message.includes('Success')) {
                    swal({
                        'title':'Success',
                        'text':result.message,
                        'type':'success',
                    },function() {
                        $('#upload_poster').modal('hide');
                        location.reload();
                    })
                } 
            },
            error: function(data) {
                swal("Error", data, "error");
            }
        });

    });
});

$(document).ready(function() {
    $(document).on('submit', '#formUploadDosen', function(event) {
        event.preventDefault();
        // console.info($(this)[0]);
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "File sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/setting/dosen/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.info(result);
                if (result.message.includes('invalid')) {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                } else if (result.message.includes('Success')) {
                    swal({ title: "Success!", text: result.message, type: "success" },
                        function() {
                            location.reload();
                        })
                } else {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                }
            },
            error: function(data) {
                console.log(data);
            }
        });

    });
});

$(document).ready(function() {
    $(document).on('submit', '#formUploadLppm', function(event) {
        event.preventDefault();
        // console.info($(this)[0]);
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "File sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/setting/admin_lppm/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.info(result);
                if (result.message.includes('invalid')) {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                } else if (result.message.includes('Success')) {
                    swal({ title: "Success!", text: result.message, type: "success" },
                        function() {
                            location.reload();
                        })
                } else {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                }
            },
            error: function(data) {
                console.log(data);
            }
        });

    });
});

$(document).ready(function() {
    $(document).on('submit', '#formUploadFakultas', function(event) {
        event.preventDefault();
        // console.info($(this)[0]);
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "File sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/setting/admin_fakultas/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.info(result);
                if (result.message.includes('invalid')) {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                } else if (result.message.includes('Success')) {
                    swal({ title: "Success!", text: result.message, type: "success" },
                        function() {
                            location.reload();
                        })
                } else {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                }
            },
            error: function(data) {
                console.log(data);
            }
        });

    });
});

$(document).ready(function() {
    $(document).on('submit', '#formUploadRevLppm', function(event) {
        event.preventDefault();
        // console.info($(this)[0]);
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "File sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/setting/reviewer_lppm/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result);
                if (result.message.includes('invalid')) {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                } else if (result.message.includes('Success')) {
                    swal({ title: "Success!", text: result.message, type: "success" },
                        function() {
                            location.reload();
                        })
                } else {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                }
            },
            error: function(data) {
                console.log(data);
            }
        });

    });
});

$(document).ready(function() {
    $(document).on('submit', '#formUploadRevFakultas', function(event) {
        event.preventDefault();
        // console.info($(this)[0]);
        var formData = new FormData($(this)[0]);

        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host;
        var val = "assets/images/loading.gif";
        var baseUrlImg = baseUrl + "/" + val;

        window.swal({
            title: "Please wait",
            text: "File sedang diproses...",
            imageUrl: baseUrlImg,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/setting/reviewer_fakultas/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result);
                if (result.message.includes('invalid')) {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                } else if (result.message.includes('Success')) {
                    swal({ title: "Success!", text: result.message, type: "success" },
                        function() {
                            location.reload();
                        })
                } else {
                    swal({ title: "Warning!", text: result.message, type: "warning" },
                        function() {
                            location.reload();
                        })
                }
            },
            error: function(data) {
                console.log(data);
            }
        });

    });
});


//fungsi untuk get data based on ketik search, ganti size data, sorting data, atau klik pagination
function fetch_data(page, sort_type, sort_by, query, tipe_form, size, col_name = null) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/pagination/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query + "&tipe_form=" + tipe_form + "&size=" + size,
        success: function(data) {
            $('tbody').html('');
            $('tbody').html(data);
        }
    })
}

//end for search data


$(document).on('click', '.delete-jurnal', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/jurnal/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Deleted!", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

$(document).on('click', '.btnUpdateDOI', function(){
    var id = $(this).attr('data-id');
    var status = $(this).attr('data-status');

    var url = '/insentif/doi/updatepengajuan';

    var post = {
        'id': id,
        'status': status
    };

    var txt = '';
    var btnColor = '';
    if(status == 'Setuju'){
        txt = "Anda yakin ingin menyetujui pengajuan ini?";
        btnColor = '#277de1';
    }else{
        txt = "Anda yakin ingin menolak pengajuan ini?";
        btnColor = '#dc3545';
    }
    
    swal({
        title: "Konfirmasi",
        text: txt,
        type: "info",
        showCancelButton: true,
        confirmButtonColor: btnColor,
        confirmButtonText: "Ya, Proses",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: post,
                url: url,
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Sukses", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        }
    });

    return false;
});

$(document).on('click', '.btnUpdatePj', function(){
    var id = $(this).attr('data-id');
    var status = $(this).attr('data-status');

    var url = '/insentif/pengelola_jurnal/updatepengajuan';

    var post = {
        'id': id,
        'status': status
    };

    var txt = '';
    var btnColor = '';
    if(status == 'Setuju'){
        txt = "Anda yakin ingin menyetujui pengajuan ini?";
        btnColor = '#277de1';
    }else{
        txt = "Anda yakin ingin menolak pengajuan ini?";
        btnColor = '#dc3545';
    }
    
    swal({
        title: "Konfirmasi",
        text: txt,
        type: "info",
        showCancelButton: true,
        confirmButtonColor: btnColor,
        confirmButtonText: "Ya, Proses",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: post,
                url: url,
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Sukses", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            }
                        );
                    } else {
                        swal("Warning", data.message, "warning")
                    }
                }
            })
        }
    });

    return false;
});

$(document).on('click', '.delete-hibah', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/hibah/penelitian/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

$(document).on('click', '.delete-riwayat', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/riwayatusulan/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete user lppm
$(document).on('click', '.delete-user-lppm', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/setting/admin_lppm/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete user fakultas
$(document).on('click', '.delete-user-fakultas', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/setting/admin_fakultas/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

$(document).on('click', '#showkuesioner', function(){
    $('#detailKuesionerModal').modal({
        backdrop: 'static',
        keyboard: true, 
        show: true
    });
    var data = $(this).attr('data-id');
    
    var arr = data.split('|');
    var propid = arr[0];
    var userid = arr[1];

    var url = '/pelaksanaan_kegiatan/laporan_akhir/showkuesioner/'+propid+'/'+userid;
    
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;

    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function(data) {
            $('#appendNilai').empty();
            $('#namaKetua').html(data.nama_dosen);
            $('#judulProposal').html(data.judul_proposal);
            $('#namaMitra').html(data.nama_mitra);
            $('#alamatMitra').html(data.alamat_mitra);
            $('#bidangUsahaMitra').html(data.bidang_usaha_mitra);
            $('#noKontakMitra').html(data.nomor_kontak_mitra);
            $('#saranRekomendasi').html(data.saran_rekomendasi);
            $('#berkasKuesioner').html('<a href="'+baseUrl+'/upload/form_kepuasan_mitra/'+data.file_name+'">'+data.file_name+'</a>');
            var str = '';
            for(var i=0;i<data.arr_pertanyaan.length;i++){
                str += '<tr>'+
                        '<td>'+(i+1)+'</td>'+
                        '<td>'+data.arr_pertanyaan[i].pertanyaan+'</td>'+
                        '<td>'+data.arr_pertanyaan[i].jawaban+'</td>'+
                    '</tr>';
            }
            $('#appendNilai').html(str);
        }
    });

    return false;
});

$(document).on('click', '#isiKuesioner', function(){
    $('#isiKuesionerModal').modal({
        backdrop: 'static',
        keyboard: true, 
        show: true
    });
    var data = $(this).attr('data-id');
    var arr = data.split('|');
    var propid = arr[0];
    var userid = arr[1];
    $('#proposalid').val(propid);
    $('#userid').val(userid);

    $.ajax({
        type: 'GET',
        url: '/pelaksanaan_kegiatan/laporan_akhir/getpertanyaan/'+propid,
        dataType: 'json',
        success: function(data) {
            $('#pertanyaan').empty();
            $('#namaKetua').html(data.nama_ketua);
            $('#judulProposal').html(data.judul_proposal);
            var str = '';
            for(var i=0;i<data.pertanyaan.length;i++){
                str += '<div class="col-lg-12 col-md-12 col-sm-12 form-control-label">'+
                        '<label><b>'+(i+1)+'. '+data.pertanyaan[i].pertanyaan+'</b></label>'+
                    '</div>'+
                    '<div class="col-lg-12 col-md-12 col-sm-12">';
                if(data.pertanyaan[i].jenis_hibah == 'Penelitian'){
                    str += '<table style="width: 100%" class="table table-borderless">'+
                        '<tr>'+
                            '<td style="width: 3%"><input type="radio" value="Sangat Baik" name="nilai['+data.pertanyaan[i].kuesioner_kepuasan_mitra_id+']"></td>'+
                            '<td style="width: 97%">Sangat Baik</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td style="width: 3%"><input type="radio" value="Baik" name="nilai['+data.pertanyaan[i].kuesioner_kepuasan_mitra_id+']"></td>'+
                            '<td style="width: 97%">Baik</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td style="width: 3%"><input type="radio" value="Kurang Baik" name="nilai['+data.pertanyaan[i].kuesioner_kepuasan_mitra_id+']"></td>'+
                            '<td style="width: 97%">Kurang Baik</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td style="width: 3%"><input type="radio" value="Tidak Baik" name="nilai['+data.pertanyaan[i].kuesioner_kepuasan_mitra_id+']"></td>'+
                            '<td style="width: 97%">Tidak Baik</td>'+
                        '</tr>'+
                    '</table>';
                }else{
                    str += '<table style="width: 100%" class="table table-borderless">'+
                        '<tr>'+
                            '<td style="width: 3%"><input type="radio" value="Sangat Puas" name="nilai['+data.pertanyaan[i].kuesioner_kepuasan_mitra_id+']"></td>'+
                            '<td style="width: 97%">Sangat Puas</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td style="width: 3%"><input type="radio" value="Puas" name="nilai['+data.pertanyaan[i].kuesioner_kepuasan_mitra_id+']"></td>'+
                            '<td style="width: 97%">Puas</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td style="width: 3%"><input type="radio" value="Kurang Puas" name="nilai['+data.pertanyaan[i].kuesioner_kepuasan_mitra_id+']"></td>'+
                            '<td style="width: 97%">Kurang Puas</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td style="width: 3%"><input type="radio" value="Tidak Puas" name="nilai['+data.pertanyaan[i].kuesioner_kepuasan_mitra_id+']"></td>'+
                            '<td style="width: 97%">Tidak Puas</td>'+
                        '</tr>'+
                    '</table>';
                }
                str+='</div>';
            }
            $('#pertanyaan').html(str);
        }
    });

    return false;
});

$(document).on('click', '#btnSaveNilai', function(){
    var form_data = new FormData($('#formNilai')[0]);
    var url = '/pelaksanaan_kegiatan/laporan_akhir/postkuesioner';
    
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;
    
    window.swal({
        title: "Please wait",
        text: "Sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: form_data,
        url: url,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.status) {
                swal({ title: "Sukses!", text: "Anda sudah berhasil menyimpan kuesioner!", type: "success" },
                function() {
                    $('#isiKuesionerModal').modal('hide');
                    location.reload();
                })
            } else {
                swal({
                    title: "Gagal",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay!",
                    closeOnConfirm: true
                })
            }
        }
    });

    return false;
});

// Delete user dosen
$(document).on('click', '.delete-user-dosen', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/setting/dosen/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal({ title: "Fail!", text: data.message, type: "error" })
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete peneliti asing
$(document).on('click', '.delete-peneliti-asing', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/sumber_daya/penelitian/peneliti_asing/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Checked role admin lppm
var temp = '';
$(document).on('change', '#radio2', function(e) {
    $('#cb2').prop('checked', true);
    $('#cb6').prop('checked', false);
    $('#cb2').prop('disabled', true);
    $('#cb6').prop('disabled', false);
});

$(document).on('change', '#radio6', function(e) {
    $('#cb6').prop('checked', true);
    $('#cb2').prop('checked', false);
    $('#cb6').prop('disabled', true);
    $('#cb2').prop('disabled', false);
});

$(document).on('keydown', '.num', function(e) {

    if (!((e.keyCode > 95 && e.keyCode < 106) ||
            (e.keyCode > 47 && e.keyCode < 58) ||
            e.keyCode == 8)) {
        return false;
    }
});

$(document).on('keydown', '.tipenumber', function(e) {
    if (!((e.keyCode > 95 && e.keyCode < 106) ||
            (e.keyCode > 47 && e.keyCode < 58) ||
            e.keyCode == 8 || e.keyCode == 9)) {
        return false;
    }
});

$(document).on('change', '.tipenumber', function(e) {
    var a = $(this).val();
    if(a.indexOf('%') != -1){
        a = a.substring(0, a.length-1);
    }
    $(this).val(a);
});

var idxisbn = 0;
$(document).on('keyup', '.isbn-column', function() {
    console.info($(this).val().length, $(this).attr("maxLength"))
    if ($(this).val().length >= $(this).attr("maxLength")) {
        if (idxisbn <= 4)
            idxisbn++;
        $('.isbn-column')[idxisbn].focus();
    }
});


$(document).on('keyup', '.issn-column', function() {
    var len = $(this).val().length;
    var max = parseInt($(this).attr("maxLength"));
    if (len >= max) {
        $('.issn-column')[1].focus();
    }
});

$(document).on('keyup', '.num', function(e) {
    if ($(this).val().length > 3)
        $(this).val($(this).val().substr(0, 3))
});

$(document).on('keyup', '#persentase_kegiatan', function(e) {
    if ($(this).val().length > 3){
        $(this).val($(this).val().substr(0, 3))
    }

    if(parseInt($(this).val()) > 100){
        $(this).val('100')
    }
});

$(document).ready(function() {
    var option = JSON.parse($('#exception_hibah_hidden').val());

    $("#selectException").val(option).selectpicker("refresh");
});

$(document).on('keydown', '.nums', function(e) {
    if (!((e.keyCode > 95 && e.keyCode < 106) ||
            (e.keyCode > 47 && e.keyCode < 58) ||
            e.keyCode == 8)) {
        return false;
    }
});

$(document).on('keyup', '.nums', function() {
    var n = parseInt($(this).val().replace(/\D/g, ''), 10);
    if($(this).val() == ''){
        $(this).val("0");
    } else {
        $(this).val(n.toLocaleString());
    }
});

$(document).on("submit", "#form_hub_kami", function(e) {
    var url = "/umum/contact/store";
    var form_data = new FormData($(this)[0]);

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.status == true) {
                swal({ title: "Sukses!", text: "Anda sudah berhasil mengirim pesan kepada admin website!", type: "success" },
                function() {
                    $('#form_hub_kami')[0].reset();
                    // window.location.replace(data.redirect_url);
                })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit add pengelola jurnal
$(document).on("submit", "#frm_add_pengelola_jurnal", function(e) {
    var url = "/setting/pengelola_jurnal/store";
    var form_data = $("#frm_add_pengelola_jurnal").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status) {
                swal({ title: "Sukses!", text: "Data yang Anda isi berhasil diupdate dan disimpan!", type: "success" },
                function() {
                    window.location.replace(data.redirect_url);
                })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit edit pengelola jurnal
$(document).on("submit", "#frm_edit_pengelola_jurnal", function(e) {
    var data_id = $('#valId').val();
    var url = "/setting/pengelola_jurnal/update/" + data_id;
    var form_data = $("#frm_edit_pengelola_jurnal").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Perubahan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                swal({ title: "Sukses!", text: "Data yang Anda isi berhasil diupdate dan disimpan!", type: "success" },
                function() {
                    window.location.replace(data.redirect_url);
                })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit add admin lppm
$(document).on("submit", "#frm_add_user_lppm", function(e) {
    var url = "/setting/admin_lppm/store";
    var form_data = $("#frm_add_user_lppm").serializeArray();
    if ($('#cb2').prop('checked'))
        form_data.push({ 'name': 'role[]', 'value': $('#cb2').val() });
    if ($('#cb6').prop('checked'))
        form_data.push({ 'name': 'role[]', 'value': $('#cb6').val() });

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                swal({ title: "Sukses!", text: "Data yang Anda isi berhasil diupdate dan disimpan!", type: "success" },
                function() {
                    window.location.replace(data.redirect_url);
                })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit add admin fakultas
$(document).on("submit", "#frm_add_user_fakultas", function(e) {
    var url = "/setting/admin_fakultas/store";
    var form_data = $("#frm_add_user_fakultas").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                window.location.replace(data.redirect_url);
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        },
        error: function(xhr, status, error) {
            // var err = JSON.parse(xhr.responseText);
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

$(document).ready(function() {
    var n = parseInt($('#jumlah_dana').val().replace(/\D/g, ''), 10);
    $('#jumlah_dana').val(n.toLocaleString());

    var n = parseInt($('#biaya').val().replace(/\D/g, ''), 10);
    $('#biaya').val(n.toLocaleString());

    // Get Program Studi
    function get_prodi() {
        var id = $('#fakultas option:selected').val();
        var url = "/setting/dosen/prodi/" + id;
        var my_html = "";

        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.length !== 0) {
                    data.forEach(element => {
                        var prodi_id = element.prodi_id;
                        var nama_prodi = element.nama_prodi;
                        my_html += '<option value=' + prodi_id + '>' + nama_prodi + '</option>';
                    });
                    $("#prodi").html(my_html);
                }
            },
            error: function() {
                console.log('Failed');
            }
        });
    }

    get_prodi();

    $("#fakultas").change(function() {
        get_prodi();
    });
});

// Submit add admin fakultas
$(document).on("submit", "#frm_add_dosen", function(e) {
    var url = "/setting/dosen/store";
    var form_data = $("#frm_add_dosen").serializeArray();
    var post = {};
    post.name = "bidang_ilmu_array";
    post.value = $('#bid_ilmu').val();
    form_data.push(post);

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });
    
    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                swal({ title: "Sukses!", text: "Data yang Anda isi berhasil diupdate dan disimpan!", type: "success" },
                function() {
                    window.location.replace(data.redirect_url);
                })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit add admin fakultas
$(document).on("submit", "#frm_add_peneliti_asing", function(e) {
    var url = "/sumber_daya/penelitian/peneliti_asing/store";
    var form_data = $("#frm_add_peneliti_asing").serializeArray();
    var post = {};
    post.name = "bidang_ilmu_array";
    post.value = $('#bid_ilmu').val();
    form_data.push(post);

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                window.location.replace(data.redirect_url);
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

// Submit add staf pendukung
$(document).on("submit", "#frm_add_staf_pendukung", function(e) {
    var url = "/sumber_daya/penelitian/staf_pendukung/store";
    var form_data = $("#frm_add_staf_pendukung").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                window.location.replace(data.redirect_url);
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

// Submit edit admin lppm
$(document).on("submit", "#frm_edit_user_lppm", function(e) {
    var data_id = $('#valId').val();
    var url = "/setting/admin_lppm/update/" + data_id;
    var form_data = $("#frm_edit_user_lppm").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Perubahan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                swal({ title: "Sukses!", text: "Data yang Anda isi berhasil diupdate dan disimpan!", type: "success" },
                function() {
                    window.location.replace(data.redirect_url);
                })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit edit admin fakultas
$(document).on("submit", "#frm_edit_user_fakultas", function(e) {
    var data_id = $('#valId').val();
    var url = "/setting/admin_fakultas/update/" + data_id;
    var form_data = $("#frm_edit_user_fakultas").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                window.location.replace(data.redirect_url);
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

// Submit edit akun dosen
$(document).on("submit", "#frm_edit_dosen", function(e) {
    var data_id = $('#valId').val();
    var url = "/setting/dosen/update/" + data_id;
    $('#bidilmu_selected').val(JSON.stringify($('#bid_ilmu').val()));
    var form_data = $("#frm_edit_dosen").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Perubahan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status) {
                swal({ title: "Sukses!", text: "Data yang Anda isi berhasil diupdate dan disimpan!", type: "success" },
                function() {
                    window.location.replace(data.redirect_url);
                })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
                return;
            }
        }
    });

    e.preventDefault();
});

// Submit edit peneliti asing
$(document).on("submit", "#frm_edit_peneliti_asing", function(e) {
    var data_id = $('#valId').val();
    var url = "/sumber_daya/penelitian/peneliti_asing/update/" + data_id;
    var form_data = $("#frm_edit_peneliti_asing").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status) {
                window.location.replace(data.redirect_url);
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
                return;
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

// Submit edit staf pendukung
$(document).on("submit", "#frm_edit_staf_pendukung", function(e) {
    var data_id = $('#valId').val();
    var url = "/sumber_daya/penelitian/staf_pendukung/update/" + data_id;
    var form_data = $("#frm_edit_staf_pendukung").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status) {
                window.location.replace(data.redirect_url);
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
                return;
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

// Submit add reviewer lppm
$(document).on("submit", "#frm_add_reviewer_lppm", function(e) {
    var url = "/setting/reviewer_lppm/store";
    var form_data = $("#frm_add_reviewer_lppm").serializeArray();
    if ($('#cb2').prop('checked'))
        form_data.push({ 'name': 'role[]', 'value': $('#cb2').val() });
    if ($('#cb6').prop('checked'))
        form_data.push({ 'name': 'role[]', 'value': $('#cb6').val() });

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                window.location.replace(data.redirect_url);
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

// Submit edit reviewer lppm
$(document).on("submit", "#frm_edit_reviewer_lppm", function(e) {
    var data_id = $('#valId').val();
    var url = "/setting/reviewer_lppm/update/" + data_id;
    var form_data = $("#frm_edit_reviewer_lppm").serializeArray();
    
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                window.location.replace(data.redirect_url);
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});


// delete pengelola jurnal
$(document).on('click', '.delete-pengelola', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/settings/pengelola_jurnal/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Terhapus", text: "Data berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// delete proposal
$(document).on('click', '.delete-proposal', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/proposalhibah/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Terhapus", text: "Data berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// delete pengajuan
$(document).on('click', '.delete-pengajuan', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/insentif/pengajuan/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Berhasil", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

$(document).on('click', '.delete-doi', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/insentif/doi/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Berhasil", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

$(document).on('click', '.delete-insentif-pj', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/insentif/pengelola_jurnal/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        swal({ title: "Berhasil", text: data.message, type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            // swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete user lppm
$(document).on('click', '.delete-reviewer-lppm', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/setting/reviewer_lppm/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal("Deleted!", "Data yang kamu pilih berhasil dihapus", "success",
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Submit add reviewer fakultas
$(document).on("submit", "#frm_add_reviewer_fakultas", function(e) {
    var url = "/setting/reviewer_fakultas/store";
    var form_data = $("#frm_add_reviewer_fakultas").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                window.location.replace(data.redirect_url);
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

// Submit edit reviewer fakultas
$(document).on("submit", "#frm_edit_reviewer_fakultas", function(e) {
    var data_id = $('#valId').val();
    var url = "/setting/reviewer_fakultas/update/" + data_id;
    var form_data = $("#frm_edit_reviewer_fakultas").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                window.location.replace(data.redirect_url);
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan!',xhr.responseText,'error');
        }
    });

    e.preventDefault();
});

// Delete user reviewer fakultas
$(document).on('click', '.delete-reviewer-fakultas', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/setting/reviewer_lppm/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal("Deleted!", "Data yang kamu pilih berhasil dihapus", "success",
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data luaran lain
$(document).on('click', '.delete-luaran-lain', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/penelitian/luaranlain/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data forum ilmiah
$(document).on('click', '.delete-forum-ilmiah', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/forumilmiah/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data hki
$(document).on('click', '.delete-data-hki', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/penelitian/hki/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data pemakalah
$(document).on('click', '.delete-pemakalah-forum-ilmiah', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/penelitian/pemakalah/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data buku ajar
$(document).on('click', '.delete-buku-ajar', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/penelitian/bukuajar/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data buku ajar
$(document).on('click', '.delete-data-media', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/pengmas/media/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data staf pendukung
$(document).on('click', '.delete-staf-pendukung', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/sumber_daya/penelitian/staf_pendukung/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data unit bisnis hasil riset
$(document).on('click', '.delete-bisnis-riset', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/unitbisnishasilriset/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data produk
$(document).on('click', '.delete-data-produk', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/pengmas/produk/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data mitra hukum
$(document).on('click', '.delete-data-mitra-hukum', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/pengmas/mitra_hukum/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data wira usaha
$(document).on('click', '.delete-data-wira-usaha', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/pengmas/wira_usaha/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data publikasi ilmiah penelitian
$(document).on('click', '.delete-publikasi-jurnal', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/penelitian/publikasijurnal/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data publikasi ilmiah pengmas
$(document).on('click', '.delete-publikasi-jurnal-pengmas', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/luaran/pengmas/publikasijurnal_abdimas/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data catatan harian
$(document).on('click', '.delete-catatan-harian', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/pelaksanaan_kegiatan/catatan_harian/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data fasilitas penunjang
$(document).on('click', '.delete-data-fasilitas', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/unitfasilitas/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

// Delete data kontrak kerja
$(document).on('click', '.delete-kontrak-kerja', function(e) {
    var data_id = $(this).attr("data-id");
    var url = "/kontrakkerja/delete/" + data_id;

    swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak akan dapat memulihkan data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak, batalkan!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        swal({ title: "Deleted!", text: "Data yang kamu pilih berhasil dihapus", type: "success" },
                            function() {
                                location.reload();
                            })
                    } else {
                        swal("Error", data.message, "error")
                    }
                }
            })
        } else {
            swal("Cancelled", "Data anda aman!", "error");
        }
    })
});

$("#selectedAll").click(function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
});

// Submit set role admin lppm
$("#submit_set_role_admin_fakultas").click(function(e) {
    var url = "/setting/admin_fakultas/set_roles";
    var form_data = $("#set_role_admin_fakultas").serializeArray();

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                $('#add_existing_data').modal('hide');
                swal({ title: "Success!", text: "Anda berhasil melakukan set role!", type: "success" },
                    function() {
                        window.location.replace(data.redirect_url);
                    })
            } else {
                $('#add_existing_data').modal('hide');
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit set role admin fakultas
$("#submit_set_role").click(function(e) {
    var url = "/setting/admin_lppm/set_roles";
    var form_data = $("#set_role").serializeArray();

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                $('#add_existing_data').modal('hide');
                swal({ title: "Success!", text: "Anda berhasil melakukan set role!", type: "success" },
                    function() {
                        window.location.replace(data.redirect_url);
                    })
            } else {
                $('#add_existing_data').modal('hide');
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit set role dosen
$("#submit_set_role_dosen").click(function(e) {
    var url = "/setting/dosen/set_roles";
    var form_data = $("#set_role_dosen").serializeArray();

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                $('#add_existing_data').modal('hide');
                swal({ title: "Success!", text: "Anda berhasil melakukan set role!", type: "success" },
                    function() {
                        window.location.replace(data.redirect_url);
                    })
            } else {
                $('#add_existing_data').modal('hide');
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit set role reviewer lppm
$("#submit_set_role_reviewer_lppm").click(function(e) {
    var url = "/setting/reviewer_lppm/set_roles";
    var form_data = $("#set_role_reviewer_lppm").serializeArray();

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                $('#add_existing_data').modal('hide');
                swal({ title: "Success!", text: "Anda berhasil melakukan set role!", type: "success" },
                    function() {
                        window.location.replace(data.redirect_url);
                    })
            } else {
                $('#add_existing_data').modal('hide');
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
});

// Submit set role reviewer fakultas
$("#submit_set_role_reviewer_fakultas").click(function(e) {
    var url = "/setting/reviewer_fakultas/set_roles";
    var form_data = $("#set_role_reviewer_fakultas").serializeArray();

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                $('#add_existing_data').modal('hide');
                swal({ title: "Success!", text: "Anda berhasil melakukan set role!", type: "success" },
                    function() {
                        window.location.replace(data.redirect_url);
                    })
            } else {
                $('#add_existing_data').modal('hide');
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
    return false;
});

// Forgot password
$("#forgot-password-submit").click(function(e) {
    var url = "/authentication/forgotpasswordprocess";
    var form_data = $("#form_forgot_password").serializeArray();

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        success: function(data) {
            console.info(data);
            if (data.status === true) {
                swal({ title: "Success!", text: data.message, type: "success" },
                    function() {
                        window.location.replace(data.redirect_url);
                    })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
    return false;
});

// Update Forgot password
$("#new-forgot-password-submit").click(function(e) {
    var url = "/authentication/forgotpasswordprocess/update";
    var form_data = $("#form_update_password").serializeArray();

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            if (data.status === true) {
                swal({ title: "Success!", text: data.message, type: "success" },
                    function() {
                        window.location.replace(data.redirect_url);
                    })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        }
    });

    e.preventDefault();
    return false;
});

// Change Forgot password
$("#to_change_password").click(function(e) {
    var url = "/home/changepassword/action";
    var form_data = $("#frm_change_password").serializeArray();

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    var val = "assets/images/loading.gif";
    var baseUrlImg = baseUrl + "/" + val;

    window.swal({
        title: "Please wait",
        text: "Penyimpanan sedang diproses...",
        imageUrl: baseUrlImg,
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        type: 'POST',
        data: form_data,
        url: url,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.status === true) {
                swal({ title: "Success!", text: data.message, type: "success" },
                    function() {
                        window.location.replace(data.redirect_url);
                    })
            } else {
                swal({
                    title: "Failed",
                    text: data.message,
                    type: "warning",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Okay, got it!",
                    closeOnConfirm: true
                })
            }
        },
        error: function(xhr, status, error) {
            swal('Kesalahan',xhr.responseText,'error');
        }
    });

    e.preventDefault();
    return false;
});

// Search list js
$(document).ready(function() {
    "use strict";

    var options = {
        valueNames: ['name', 'born']
    };

    var userList = new List('users', options);
});

function setStyleSheet(url) {
    var stylesheet = document.getElementById("theme_stylesheet");
    stylesheet.setAttribute('href', url);
}

// H menu
$(window).bind("resize", function() {
    console.log($(this).width())
    if ($(this).width() < 1201) {
        $('.horizontal').removeClass('h_menu')
    } else {
        $('.horizontal').addClass('h_menu')
    }
}).trigger('resize');

window.anchor = {
    colors: {
        'theme1-one': '#6435c9',
        'theme1-two': '#f66d9b',



        'blue': '#467fcf',
        'blue-darkest': '#0e1929',
        'blue-darker': '#1c3353',
        'blue-dark': '#3866a6',
        'blue-light': '#7ea5dd',
        'blue-lighter': '#c8d9f1',
        'blue-lightest': '#edf2fa',
        'azure': '#45aaf2',
        'azure-darkest': '#0e2230',
        'azure-darker': '#1c4461',
        'azure-dark': '#3788c2',
        'azure-light': '#7dc4f6',
        'azure-lighter': '#c7e6fb',
        'azure-lightest': '#ecf7fe',

        'indigo': '#6435c9',
        'indigo-darkest': '#3e0ca9',
        'indigo-darker': '#5322bb',
        'indigo-dark': '#5929c1',
        'indigo-light': '#7d53d6',
        'indigo-lighter': '#9773e4',
        'indigo-lightest': '#a28ad6',

        'purple': '#a55eea',
        'purple-darkest': '#21132f',
        'purple-darker': '#42265e',
        'purple-dark': '#844bbb',
        'purple-light': '#c08ef0',
        'purple-lighter': '#e4cff9',
        'purple-lightest': '#f6effd',

        'pink': '#f66d9b',
        'pink-darkest': '#31161f',
        'pink-darker': '#622c3e',
        'pink-dark': '#c5577c',
        'pink-light': '#f999b9',
        'pink-lighter': '#fcd3e1',
        'pink-lightest': '#fef0f5',

        'red': '#e74c3c',
        'red-darkest': '#2e0f0c',
        'red-darker': '#5c1e18',
        'red-dark': '#b93d30',
        'red-light': '#ee8277',
        'red-lighter': '#f8c9c5',
        'red-lightest': '#fdedec',
        'orange': '#fd9644',
        'orange-darkest': '#331e0e',
        'orange-darker': '#653c1b',
        'orange-dark': '#ca7836',
        'orange-light': '#feb67c',
        'orange-lighter': '#fee0c7',
        'orange-lightest': '#fff5ec',
        'yellow': '#f1c40f',
        'yellow-darkest': '#302703',
        'yellow-darker': '#604e06',
        'yellow-dark': '#c19d0c',
        'yellow-light': '#f5d657',
        'yellow-lighter': '#fbedb7',
        'yellow-lightest': '#fef9e7',
        'lime': '#7bd235',
        'lime-darkest': '#192a0b',
        'lime-darker': '#315415',
        'lime-dark': '#62a82a',
        'lime-light': '#a3e072',
        'lime-lighter': '#d7f2c2',
        'lime-lightest': '#f2fbeb',
        'green': '#5eba00',
        'green-darkest': '#132500',
        'green-darker': '#264a00',
        'green-dark': '#4b9500',
        'green-light': '#8ecf4d',
        'green-lighter': '#cfeab3',
        'green-lightest': '#eff8e6',
        'teal': '#2bcbba',
        'teal-darkest': '#092925',
        'teal-darker': '#11514a',
        'teal-dark': '#22a295',
        'teal-light': '#6bdbcf',
        'teal-lighter': '#bfefea',
        'teal-lightest': '#eafaf8',
        'cyan': '#17a2b8',
        'cyan-darkest': '#052025',
        'cyan-darker': '#09414a',
        'cyan-dark': '#128293',
        'cyan-light': '#5dbecd',
        'cyan-lighter': '#b9e3ea',
        'cyan-lightest': '#e8f6f8',

        'gray': '#868e96',
        'gray-darkest': '#1b1c1e',
        'gray-darker': '#36393c',
        'gray-dark': '#6b7278',
        'gray-light': '#aab0b6',
        'gray-lighter': '#dbdde0',
        'gray-lightest': '#f3f4f5',
        'gray-dark': '#343a40',
        'gray-dark-darkest': '#0a0c0d',
        'gray-dark-darker': '#15171a',
        'gray-dark-dark': '#2a2e33',
        'gray-dark-light': '#717579',
        'gray-dark-lighter': '#c2c4c6',
        'gray-dark-lightest': '#ebebec',

        'gray-100': '#E8E9E9',
        'gray-200': '#D1D3D4',
        'gray-300': '#BABDBF',
        'gray-400': '#808488',
        'gray-500': '#666A6D',
        'gray-600': '#4D5052',
        'gray-700': '#333537',
        'gray-800': '#292b30',
        'gray-900': '#1C1D1E',
    }
};