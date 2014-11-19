jQuery(document).ready(function() {
    jQuery('#profile .btn-loading').click(function() {
        var url = SITE_URL + 'profile/loadprofile';
        var month = jQuery('#profile select#bulan').val();
        var year = jQuery('#profile select#year').val();
        var office_id = jQuery('#profile select#office_id').val();
        //if(office_id = '') { alert('Silakan pilih kantor cabang.'); return false; }
        if (office_id == '' || year == '') {
            alert('Lengkapi pilihan terlebih dulu...');
            return false;
        }
        jQuery(function() {
            jQuery.ajax({
                url: url,
                dataType: 'html',
                type: 'post',
                data: {action: 'CheckData', office_id: office_id, year: year, month: month},
                beforeSend: function() {
                    jQuery('.subcriteria-ajax').html('');
                    jQuery('#profile .btn-loading').text('Awaiting....');
                },
                complete: function() {

                },
                success: function(response) {

                    jQuery('.subcriteria-ajax').html(response);
                    jQuery('#profile .btn-loading').text('Load');
                }
            })
            return false;
        });
    });

    jQuery("#resort_load").chosen().change(function() {
        var url = SITE_URL + 'pinjaman/loadanggota';
        var resort = jQuery(this).val();
        jQuery(function() {
            jQuery.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: {action: 'load_anggota', resort: resort},
                beforeSend: function() {
                    jQuery('.loading').show();
                },
                complete: function() {
                    jQuery('.loading').hide();
                },
                success: function(response) {
                    jQuery('.response').html(response);
                    jQuery('.loading').hide();
                }
            })
            return false;
        });
    });
    
    jQuery("#load_pinjaman").chosen().change(function() {
        var url = SITE_URL + 'angsuran/loadpinjaman';
        var resort = jQuery(this).val();
        jQuery(function() {
            jQuery.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: {action: 'load_pinjaman', postId: resort},
                beforeSend: function() {
                    jQuery('.loading').show();
                },
                complete: function() {
                    jQuery('.loading').hide();
                },
                success: function(response) {
                    jQuery('.response').html(response);
                    jQuery('.loading').hide();
                }
            })
            return false;
        });
    });

    jQuery("#pinj_pokok").keyup(function() {
        //var pokok1 = parseInt(this.value);
        var pokok = numbering(this.value);
        var bunga = parseFloat(pokok * 0.2);
        var total = (pokok + bunga);
        jQuery("#pinj_total").val(formatDollar(total));
        //jQuery(this).val(formatDollar(pokok));		
    });

});

function numbering(numb) {
    var thenum = parseInt(numb);
    return thenum;
}


function formatDollar(num) {
    var p = num.toFixed(2).split(".");
    return "Rp." + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}