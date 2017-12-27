$(document).ready(function() {
$('.formbuilder-button').on('click', function() {
  var node = this;

  var data = 'form_id='+ $(this).attr('data-form-id');
  
  if(data && $(this).attr('data-product-id')) {
    data += '&product_id='+ $(this).attr('data-product-id');
  }

  $.ajax({
    url: 'index.php?route=page/formpro',    
    data: data,
    type: 'post',
    dataType: 'json',
    beforeSend: function() {
      $(node).addClass('disableClick');
    },
    complete: function() {
      $(node).removeClass('disableClick');
    },
    success: function(json) {
      if(json['redirect']) {
        location = json['redirect'];
      } else if(json['html']) {
        $('body').prepend(json['html']);  

        $('#FormProModal').modal('show');
      }      
    }
  });
});


$(document).delegate('#FormProModal button[id^=\'builder-button-upload\']', 'click', function() {
  var node = this;

  $('#FormProModal #builder-form-upload').remove();

  $('#FormProModal').prepend('<form enctype="multipart/form-data" id="builder-form-upload" style="display: none;"><input type="file" name="file" /></form>');

  $('#FormProModal #builder-form-upload input[name=\'file\']').trigger('click');

  if (typeof timer != 'undefined') {
      clearInterval(timer);
  }

  timer = setInterval(function() {
    if ($('#FormProModal #builder-form-upload input[name=\'file\']').val() != '') {
      clearInterval(timer);

      $.ajax({
        url: 'index.php?route=tool/upload',
        type: 'post',
        dataType: 'json',
        data: new FormData($('#builder-form-upload')[0]),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $(node).button('loading');
        },
        complete: function() {
          $(node).button('reset');
        },
        success: function(json) {
          $('.text-danger').remove();

          if (json['error']) {
            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
          }

          if (json['success']) {
            alert(json['success']);

            $(node).parent().find('input').val(json['code']);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }
  }, 500);
});

$(document).delegate('#FormProModal .builder_country_id', 'change', function() {
  var text_select = $('#FormProModal .text_select').text();
  var text_none = $('#FormProModal .text_none').text();

  $.ajax({
    url: 'index.php?route=page/formpro/country&country_id=' + this.value,
    dataType: 'json',
    beforeSend: function() {
      $('#FormProModal .builder_country_id').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
    },
    complete: function() {
      $('.fa-spin').remove();
    },
    success: function(json) {
      html = '<option value="">'+ text_select +'</option>';

      if (json['zone'] && json['zone'] != '') {
        for (i = 0; i < json['zone'].length; i++) {
          html += '<option value="' + json['zone'][i]['zone_id'] + '"';
          html += '>' + json['zone'][i]['name'] + '</option>';
        }
      } else {
        html += '<option value="0" selected="selected">'+ text_none +'</option>';
      }

      $('#FormProModal .zone_id').html(html);
    }
  });
});

$('#FormProModal .builder_country_id').trigger('change');
});


var FORMBUILDERPRO = {
  'add': function(form_id) {

    var text_processing = $('#FormProModal .text_processing').text();

    var data = $('#pageform-pro input[type=\'text\'], #pageform-pro input[type=\'hidden\'], #pageform-pro input[type=\'password\'], #pageform-pro input[type=\'radio\']:checked, #pageform-pro input[type=\'checkbox\']:checked, #pageform-pro select, #pageform-pro textarea').serialize();

    if( data ) {
      data += '&';
    }

    data += 'form_id='+ form_id;

    if($('#button-submit-formbuilder').attr('data-product-id')) {
      data += '&product_id='+ $('#button-submit-formbuilder').attr('data-product-id');
    }

    $.ajax({
      url: 'index.php?route=page/formpro/add',
      type: 'post',
      data: data,
      dataType: 'json',
      beforeSend: function() {
        $('#button-submit-formbuilder').button('loading');

        $('#FormProModal .alert, #FormProModal .text-danger').remove();
        $('#FormProModal .form-group').removeClass('has-error');

        $('#FormProModal .modal-body').prepend('<div class="alert alert-info information"><i class="fa fa-circle-o-notch fa-spin"></i> ' + text_processing + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      },
      complete: function() {
        $('#button-submit-formbuilder').button('reset');
      },
      success: function(json) {
        $('#FormProModal .alert, #FormProModal .text-danger').remove();
        $('#FormProModal .form-group').removeClass('has-error');

        if (json['error']) {
          if (json['error']['field']) {
            for (i in json['error']['field']) {
              var element = $('#FormProModal #input-field' + i.replace('_', '-'));
              if (element.parent().hasClass('input-group')) {
                element.parent().after('<div class="text-danger">' + json['error']['field'][i] + '</div>');
              } else {
                element.after('<div class="text-danger">' + json['error']['field'][i] + '</div>');
              }
            }
          }

          if(json['captcha']) {
            $('#FormProModal .cicaptcha').html(json['captcha']);
          }

          if (json['error']['warning']) {
            $('#FormProModal .modal-body').prepend('<div class="alert alert-danger warning"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

            // $('html, body').animate({ scrollTop: 0 }, 'slow');
          }

          // Highlight any found errors
          $('#FormProModal .text-danger').parent().parent().addClass('has-error');
        }

        if (json['success']) {
          $('#FormProModal .modal-title').html(json['success_title']);

          $('#FormProModal .modal-body').html(json['success_message'] + '<div class="buttons clearfix"><div class="pull-right"><button class="btn btn-primary button" data-dismiss="modal">'+ json['success_button_continue'] +'</button></div></div>');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }
}