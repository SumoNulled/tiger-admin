<script>
    $(document).ready(function() {
        $(function() {
          // Value 2 = "Headquarters Company"
            if (
            $("#company_select").val() == "" ||
            $("#company_select").val() == "2" ||
            $("#company_select").val() == "3" ||
            $("#company_select").val() == "4")
            {
                $('#platoon_div').hide();
                $("#platoon_select").val("").change();

                $('#squad_div').hide();
                $("#squad_select").val("").change();
            }
        });

        $("#company_select").change(function() {
            var val = $(this).val();

            if (val == "1") {
                $('#platoon_div').show("slow");
                $('#squad_div').show("slow");
            }
            else if (val == "" || val == "2" || val == "3" || val == "4") {
                $('#platoon_div').hide("slow");
                $("#platoon_select").val("").change();

                $('#squad_div').hide("slow");
                $("#squad_select").val("").change();
            }
        });
    });
</script>
