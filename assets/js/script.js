jQuery(function(){

    let inputname = jQuery('.namecontactlist');
    let messagesucess = jQuery('.messageinputsuccess');
    let messageerror = jQuery('.messageinputerror');
    let messageinput = jQuery('.messageinput');
    
    //Message Warning for Character
    inputname.focus(function(){

        let inputval = inputname.val();
        let inputlength = inputval.length;

        if(inputlength < 5){

            messageinput.fadeIn(600);
            messageinput.text('Add a name with more than 5 characters');

       }else{

            messageinput.fadeOut(600);

       }
      

    });

    //Include Options

    let inputcode = jQuery('.contact_list_code_number');

    jQuery('.getcode').on('click', function(e){

        e.preventDefault();

     let countryname = jQuery('.country_name').val();

        jQuery.ajax({

            type:"GET",
            dataType: "JSON",
            url: "https://restcountries.eu/rest/v2/name/" + countryname,
            success: form_data,
            beforeSend: loading,
            error: geterror

        });

        function form_data(data){

            var data_code = [];

            data_code = data;

           jQuery.each(data_code, function(i, e){

            inputcode.val("+ " + e['callingCodes'] );

            }); 



        }

        function loading(){

            messageerror.fadeOut(400);
            messagesucess.fadeIn(600);
            messagesucess.text('Carregando');
            messagesucess.fadeOut(400);
        }


        function geterror(){

            messagesucess.fadeOut(400);
            messageerror.fadeIn(600);
            messageerror.text('Erro na Requisição');
            messageerror.fadeOut(400);
        }

    });


});