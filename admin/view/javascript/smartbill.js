$(document).ready(function(){
    $('select[name="smartbill_company"]').on('change', function(e){
        var $form = $(this).closest('.form-group');

        $form.find('.error').show();
        $form.nextAll().hide();
    });

    $('select[name="smartbill_document_type"]').on('change', function(e){
        var $form = $(this).closest('.form-group');

        switch ( $(this).val() ) {
          case '1':
            $form.find('.series-proforma').show();
            $form.find('.series-invoice').hide();
            break;

          default:
            $form.find('.series-proforma').hide();
            $form.find('.series-invoice').show();
            break;
        }
    }).trigger('change');
    /*
    $('select[name="smartbill_document_type"]').on('change', function(){
        var $t = $(this);

        switch ( $t.val() ) {
            case 0:
                _changeSeriesVisibility('smartbill_invoice_series', true);
                _changeSeriesVisibility('smartbill_proforma_series', false);
                break; 

            case 1:
                _changeSeriesVisibility('smartbill_invoice_series', false);
                _changeSeriesVisibility('smartbill_proforma_series', true);
                break;
        }
    });
    $('select[name="smartbill_document_type"]').trigger('change');

    function _changeSeriesVisibility(name, makeVisible) {
        var $obj = $('select[name="' + name + '"]').closest('tr') || null;

        try {
            if ( makeVisible ) {
                $obj.show();
            } else {
                $obj.hide();
            }
        } catch (ex) {}
    }
    */
});