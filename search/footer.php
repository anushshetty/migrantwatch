<script>


var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;

function jsddm_open()
{  jsddm_canceltimer();
   jsddm_close();
   ddmenuitem = $(this).find('ul').css('visibility', 'visible');}

function jsddm_close()
{  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function jsddm_timer()
{  closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer()
{  if(closetimer)
   {  window.clearTimeout(closetimer);
      closetimer = null;}}

$(document).ready(function()
{  $('#jsddm > li').bind('mouseover', jsddm_open)
   $('#jsddm > li').bind('mouseout',  jsddm_timer)});

document.onclick = jsddm_close;
</script>

<script type="text/javascript">
$('.default-value').each(function() {
    var default_value = this.value;
    $(this).css('color', '#666'); // this could be in the style sheet instead
    $(this).focus(function() {
        if(this.value == default_value) {
            this.value = '';
            $(this).css('color', '#333');
        }
    });
    $(this).blur(function() {
        if(this.value == '') {
            $(this).css('color', '#666');
            this.value = default_value;
        }
    });
});


$('#password-clear').show();
$('#password-password').hide();

$('#password-clear').focus(function() {
    $('#password-clear').hide();
    $('#password-password').show();
    $('#password-password').focus();
});
$('#password-password').blur(function() {
    if($('#password-password').val() == '') {
        $('#password-clear').show();
        $('#password-password').hide();
    }
});

 var toggle = false;
  $(".rememberme").click(function () {
     if( toggle  == false) { 
         $('#remember').val('1'); 
         toggle = true;
     } else { 
         $('#remember').val('0'); toggle = false; 
     }
     $(".rememberme").toggle();           
  });
</script>

<script>
  $(document).ready(function(){
$('#query').emptyonclick();
 $(".sidebar").corner();
    $(".filter").corner();
    $(".first_image").corner('bottom');
$('#query').autocomplete("autocomplete.php", {
  //    width: 388,
       selectFirst: false,
           matchSubset :true,
      matchContains: false,
      formatItem: formatItem

          });

$("#query").result(function(event, data, formatted) {

				   document.location.href= "../guide.php?id="+ data[1];

});
});
function formatItem(row) {
     var completeRow;
         completeRow = new String(row);
                var scinamepos = completeRow.lastIndexOf("(");
                    var rest = completeRow.substr(0,scinamepos)
                        var sciname = completeRow.substr(scinamepos);
                            var commapos = sciname.lastIndexOf(",");
                sciname = sciname.substr(0,commapos);
                var newrow = rest + '<br><i>' + sciname + '</i>';
        	    return newrow;

  }

  </script>
