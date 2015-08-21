<link rel="stylesheet" media="screen" type="text/css" href="scripts/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="scripts/colorpicker/js/colorpicker.js"></script>

<script type="text/javascript">

    $(function() {

        $('#value, #value2').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val(hex);
                $(el).ColorPickerHide();
            },
            onBeforeShow: function () {
                $(this).ColorPickerSetColor(this.value);
            }
        })
                .bind('keyup', function(){
                    $(this).ColorPickerSetColor(this.value);
                });


    });

</script>