// Select dropdowns by value

document.querySelectorAll('[data-select]').forEach(element => {
    element.value = element.getAttribute('data-select')
});

// Reveal form submit button

$('form[data-submit] :input').change(function() {
    if($('#btn-form-submit').hasClass('d-none')) $('#btn-form-submit').removeClass('d-none')
});

$('form[data-submit] :input').keyup(function() {
    if($('#btn-form-submit').hasClass('d-none')) $('#btn-form-submit').removeClass('d-none')
});

// Show No Records in fr-container

function makeFrContainerNoRecord() {
    $('.fr-container').html(`<div class="container bg-white col-black p-3 text-center">
						        <span class="material-icons display-1">insights</span>
						        <p class="">No records found</p>
					        </div>`);
}

//

$('[data-ajax]').click(function(e) {
                
    e.preventDefault();
    
    let btn = $(this);
    
    let dataConfirm = btn.data('confirm');
    let reqUrl = btn.attr('href');
    
    if(!confirm(dataConfirm)) return false;
    
    btn.prop('disabled', true);
    btn.html('scatter_plot');
    btn.removeClass('bg-primary bg-success bg-danger').addClass('bg-danger');
    
    $("#ajax-div").load(reqUrl, function(data, status, xhr) {
        
        btn.prop('disabled', false);
        
        if(status == 'success') {
            btn.html('check');
            btn.removeClass('bg-danger').addClass('bg-primary');
        }  else {
            btn.html('error_outline');
        }
        
    });
    
})

// AJAX instead of From Submit

$('form[data-submit]').submit(function(e) {
    
    e.preventDefault();

    var form = $(this);
    var submitBtn = $(this).find(":submit");
    var url = form.attr('action');
    
    if(submitBtn.hasClass('bg-danger')) submitBtn.removeClass('bg-danger');
    submitBtn.html('scatter_plot').prop('disabled', true).removeClass('bg-primary').addClass('bg-danger');
    
    $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                document.body.insertAdjacentHTML('beforeend', data);
                submitBtn.html('check').prop('disabled', false).removeClass('bg-danger').addClass('bg-primary');
            },
            error: function (jqXHR, exception) {
                let msg = '';
                if (jqXHR.status === 0) {
                    msg = 'No Internet Connection';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500]';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                submitBtn.html('autorenew').prop('disabled', false);
                showSnack('danger', msg);
            }
         });
         
});

// SnackBar

function showSnack(type, text) {
    let snackHtml = `<div class='snackbar show'>
	        <div class='alert alert-${type}' role='alert'>
	           ${text}
	        </div>
	      </div>`;
	document.body.insertAdjacentHTML('beforeend', snackHtml);
}
  
// Make modal TOP on small devices

if($(window).width() < 575) {
   $('.modal-dialog-centered').removeClass('modal-dialog-centered');
}