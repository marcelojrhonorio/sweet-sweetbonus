/*
	Form Validation
	
	Method

   		// objForm - reference to form object
   		// 'formResultDiv' - div id to present the error mesages
   		// show_alert - shows error mesages in alert message instead of div mode
   		validateFormTemplate( objForm, divErrorId, show_alert )
	
	Attribute Description:

	validate =  "not_empty" 	- field cannot be empty. stips spaces before validation 
				"integer"   	- integer allowed
				"number" 		- decimal allowed
				"positive" 		- positive integer ou decimal value
				"email"     	- validates email syntax
				"phone_BR" 		- validate invalid phone numbers
				"phoneifen_BR"	- validate invalid phone numbers with format ((00)0000-0000)
				"phoneifen_BR_2"- validate invalid phone numbers with format (0000-0000)
				"name"			- string with 2 or more letters
				"name_surname"	- at least two names with 3 or more letters each 
				"date_PT"		- validate dates with portuguese format dd-mm-yyyy or dd/mm/yyyy
				"date_EN"		- validate dates with international format yyyy-mm-dd or yyyy-mm-dd
				"date_BR"		- validate dates with international format dd/mm/yyyy
				"url"  			- validate url address 
				"CPF"			- validate CPF format (000.000.000-00)
				"cep"			- validate cep format(00000-000)
				"cep1"			- validate cep1 format (00000) 			
				"cep2"			- validate cep2 format (000)  
				"motor"			- validate motor type format (0.0)
				"RG"			- validate RG format 00.000.000-0
				
	multiple attributs validation 
		validate="integer|positive"
		title="error message to show"
	
	
	return listener
		you can define a function with name formValidation_listener that is called on validation success
		
	
	Examples:
	
		<form onsubmit="return validateFormTemplate( this, 'formResultDiv', false );" method="post">
		
			Field with username validation:
			<input type="Text" id="username" name="username" validate="username" title="Please insert a valid username" />
		
			Field with multiple validation (not_empty and integer):
			<input type="Text" id="age" name="age" validate="not_empty|integer|positive" title="Age is mandatory and as to be a valid integer" />
			
		</form>

*/


function validateFormTemplate( objForm, divErrorId, show_alert ) {
		
    for( var i=0; i< objForm.elements.length; ++i ){
        
        var elem = objForm.elements[i];
        
        if( !elem.id || elem.length == 0 || !elem.getAttribute("validate") || elem.getAttribute("validate").length == 0 ) continue;
        
        var elemType			= elem.type;
        var elemValue 			= formValidation_getFieldValue( objForm, elem, elemType );
        var validationType 		= elem.getAttribute("validate");
        var errorMessage 		= elem.getAttribute("title");
        var arrValidationTypes 	= validationType.split("|");
        
        for (var j=0; j < arrValidationTypes.length; j++) {
            
            var blnValid = true;

            switch( arrValidationTypes[j] ){
            
                case "not_empty":
                    if( elemType == "select-one" && elemValue == 0 ) blnValid = false;
                    else{
                        if( elemType == "checkbox" && !elem.checked ) blnValid = false;
                        else{
                            if( elemType != "select-one" && formValidation_allTrim(elemValue) == "" ) blnValid = false;
                        }
                    }
                break;

                case "integer":
                    if( elemValue != "" ){
                        var filter = /^-?\d+$/;						
                        if( ! filter.test( elemValue ) ) blnValid = false;
                    }
                break;

                case "number":
                    if( elemValue != "" ){
                        var filter = /^[-+]?\d+(\.\d+)?$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                    }
                break;
                
                case "positive":
                    if( elemValue != "" ){
                        var filter = /^\d+$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                    }
                break;

                case "email":
                    if( elemValue != "" ){
                        //var filter = /^([^\.]+[a-zA-Z0-9_\.\-]+[^\.])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        //var filter = /^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/;
                        //var filter = /^[a-zA-Z][\w\.-^]*[a-zA-Z0-9\^._-]@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/;
                        var filter = /^[0-9a-zA-Z_\.\-][\w_\.\-]*[a-zA-Z0-9\^._-]@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                    }
                break;
                
                case "phone_BR":
                
                    if( elemValue != "" ){
                        var filter = /^[0-9]{8}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                        if( blnValid ){
                            if( elemValue.charAt(0) == 0 || elemValue.charAt(0) == 1 ) blnValid = false;
                            if( blnValid ){
                        if( formValidation_isInvalidPhoneNumbers( elemValue ) ) blnValid = false;
                            }
                        }
                        
                    }
                break;
                
                case "phoneifen_BR":					
                    if( elemValue != "" ){
                        var filter = /\(?[1-9]{2}\)?\d{4}-\d{4}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false; 
                        if( blnValid ){
                            if( elemValue.charAt(4) == 0 || elemValue.charAt(4) == 1 ) blnValid = false;
                            if( blnValid ){
                            elemValue = elemValue.substring(4);
                            elemValue = elemValue.replace("-","");
                            if( formValidation_isInvalidPhoneNumbers( elemValue ) ) blnValid = false;
                            }
                        }
                        
                    }
                break;
                
                case "phoneifen_BR_2":					
                    if( elemValue != "" ){
                        var filter = /\d{4}-\d{4}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                        if( blnValid ){
                            if( elemValue.charAt(0) == 0 || elemValue.charAt(0) == 1 ) blnValid = false;
                            if( blnValid ){
                                elemValue = elemValue.replace("-","");
                                if( formValidation_isInvalidPhoneNumbers( elemValue ) ) blnValid = false;
                            }
                        }
                    }
                break;
                
                case "phoneifenrequired_BR":					
                    if( elemValue != "" ){
                        var filter = /\(?\d{2}\)?\d{4}-\d{4}/;
                        if (elemValue == "(00)0000-0000") blnValid = false;
                        if( ! filter.test( elemValue ) ) blnValid = false;


                    }
                break;

                case "name":
                    
                    if( elemValue != "" ){
                        var filter = /^[A-Za-z Ã¢Ã®Ã´Ã¡Ã©Ã­Ã³ÃºÃ Ã¨Ã¬Ã²Ã¹Ã‚ÃŽÃ”ÃÃ‰ÃÃ“ÃšÃ€ÃˆÃŒÃ’Ã™Ã‡Ã§Ã¼Ã¶Ã¤ÃƒÃ•Ã‘Ã£ÃµÃ±']{3,120}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                            if( blnValid ){
                            if( formValidation_isInvalidName( elemValue ) ) blnValid = false;
                            }
                    }
                break;
                
                case "name_surname":
                    if( elemValue != "" ){
                        var names = elemValue.split(' ');
                        if( names.length <= 1 ) blnValid = false;
                        else{
                            for( var k=0; k< names.length; ++k ){
                                var filter = /^[A-Za-z Ã¢Ã®Ã´Ã¡Ã©Ã­Ã³ÃºÃ Ã¨Ã¬Ã²Ã¹Ã‚ÃŽÃ”ÃÃ‰ÃÃ“ÃšÃ€ÃˆÃŒÃ’Ã™Ã‡Ã§Ã¼Ã¶Ã¤ÃƒÃ•Ã‘Ã£ÃµÃ±']{2,200}$/;
                                if( ! filter.test( names[k] ) ){ 
                                    blnValid = false;
                                    break;
                                }
                            }
                            if( blnValid ){
                            if( formValidation_isInvalidName( elemValue ) ) blnValid = false;
                            }
                        }
                    }
                break;

                case "date_PT":
                    if( elemValue != "" )
                        blnValid = formValidation_validateDate( elemValue, 'PT' );
                break;
                
                case "date_BR":
                    if( elemValue != "" )
                        blnValid = formValidation_validateDate( elemValue, 'BR' );
                break;
                
                case "date_EN":
                    if( elemValue != "" )
                        blnValid = formValidation_validateDate( elemValue, 'EN' );
                break;
                
                case "url":
                    if( elemValue != "" ){
                        var filter = /(ftp|http|https):\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_%&\?\/.=]+$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                        
                    }
                break;
                
                case "CPF":
                    if( elemValue != "" ){		
                        var filter = /^[0-9]{3}[.]{1}[0-9]{3}[.]{1}[0-9]{3}[-]{1}[0-9]{2}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                        intCPF = replaceAll( elemValue, [[".", ""], [ "-", "" ]]);
                        if( !formValidation_isValidCPF( intCPF ) ) blnValid = false;
                    }
                break;

                case "CNPJ":
                    if( elemValue != "" ){
                        if( !formValidation_isValidCNPJ( elemValue ) ) blnValid = false;
                    }
                break;

                case "RG":
                    if( elemValue != "" ){		
                        var filter = /^[0-9]{2}[.]{1}[0-9]{3}[.]{1}[0-9]{3}[-]{1}[0-9]{1}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                        if( formValidation_isInvalidRG( elemValue ) ) blnValid = false;
                    }
                break;
                
                case "cep":
                    if( elemValue != "" ){		
                        var filter = /^[0-9]{5}[-]{1}[0-9]{3}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                        if( formValidation_isInvalidCep( elemValue ) ) blnValid = false;
                    }
                break;
                
                case  "cep1":
                    if( elemValue != "" ){
                        var filter = /^[0-9]{5}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                        if( formValidation_isInvalidCep1( elemValue ) ) blnValid = false;
                    }
                break;
                
                case "cep2":
                    if( elemValue != "" ){
                        var filter = /^[0-9]{3}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                        if( formValidation_isInvalidCep2( elemValue ) ) blnValid = false;
                    }
                break;
                
                case "motor":
                    if( elemValue != "" ){
                        var filter = /^[0-9]{1}[.]{1}[0-9]{1}$/;
                        if( ! filter.test( elemValue ) ) blnValid = false;
                    }
                break;
                
                default:
                    try{
                        blnValid = eval(arrValidationTypes[j])( elemValue );
                    }
                    catch( err ){
                        alert( "ERRO FORM_TEMPLATE: funÃ§Ã£o "+ arrValidationTypes[j] +"nÃ£o definida." );
                        blnValid = true;
                    }
                break;
            }
            
            if( !show_alert ){
                if( blnValid == false ){
                    document.getElementById(divErrorId).innerHTML = errorMessage;   
                    //elem.style.backgroundColor = "#cccccc";
                    if( elemType != "hidden" && elem.style.display != "none" && elem.style.visibility != "hidden" ) elem.focus();
                    return false;
                }
                else{
                    document.getElementById(divErrorId).innerHTML = "";
                    //elem.style.backgroundColor = "#FFFFFF";
                }
            }
            else{
                if( blnValid == false ){
                    alert( errorMessage );
                    if( elemType != "hidden" && elem.style.display != "none" && elem.style.visibility != "hidden" ) elem.focus();
                    return false;
                }
            }
        }
    }
    
    // verifies if listener is defined and calls it.
    var listener_defined = false;
    if(typeof formValidation_listener == 'function') listener_defined = true;
    if( listener_defined ) formValidation_listener();
    
    return true;
}

function formValidation_getFieldValue( formObj, elem, elemType ){
    
    switch( elemType ){
        case "text": 
            return elem.value;
        break;
        case "select":
            return elem.selectedIndex;
        break;
        case "select-one": 
            return elem.selectedIndex;
        break;
        case "radio":
            var radioObj = formObj.elements[ elem.name ];
            return formValidation_getCheckedRadio( radioObj )
        break;
        default: 
            return elem.value;
        break;
    }
    return "";
}

function formValidation_getCheckedRadio( radioObj ){
    if(!radioObj)
        return "";
    var radioLength = radioObj.length;
    if(radioLength == undefined){
        if(radioObj.checked)
            return radioObj.value;
        else
            return "";
    }
    for(var i = 0; i < radioLength; i++) {
        if(radioObj[i].checked) {
            return radioObj[i].value;
        }
    }
    return "";
}

function formValidation_allTrim(cValue){
    var lDone=false;

    while (lDone==false){
        if (cValue.length==0) {return cValue;}
        if (cValue.indexOf(' ')==0){cValue=cValue.substring(1);lDone=false; continue;}
        else {lDone=true;}
        if (cValue.lastIndexOf(' ')==cValue.length-1){cValue=cValue.substring(0, cValue.length-1);lDone=false;continue;}
        else {lDone=true;}
    }
    return cValue;
}

// returns true if recived phone is in invalid phones list
function formValidation_isInvalidPhoneNumbers( phone ){		
    var invalidPhones = ['00000000','11111111','22222222','33333333','44444444','55555555','66666666','77777777','88888888','99999999','12345678'];
    for( var i=0; i < invalidPhones.length; ++i ){
        if( phone == invalidPhones[i] ) return true;
    }
    console.warn('formValidation_isInvalidPhoneNumbers');
    return false;
}

// returns true if recived cpf is in invalid cpf list
/*function formValidation_isInvalidCPF( cpf ){		
    var invalidCPF = ['000.000.000-00','111.111.111-11','222.222.222-22','333.333.333-33','444.444.444-44','555.555.555-55','666.666.666-66','777.777.777-77','888.888.888-88','999.999.999-99'];
    for( var i=0; i < invalidCPF.length; ++i ){
        if( cpf == invalidCPF[i] ) return true;
    }
    return false;
}*/

 function formValidation_isValidCPF (CPF) {
    if (CPF.length != 11 || CPF == "00000000000" || CPF == "11111111111" ||
    CPF == "22222222222" ||	CPF == "33333333333" || CPF == "44444444444" ||
    CPF == "55555555555" || CPF == "66666666666" || CPF == "77777777777" ||
    CPF == "88888888888" || CPF == "99999999999")
    return false;
    soma = 0;
    for (i=0; i < 9; i ++)
        soma += parseInt(CPF.charAt(i)) * (10 - i);
    resto = 11 - (soma % 11);
    if (resto == 10 || resto == 11)
        resto = 0;
    if (resto != parseInt(CPF.charAt(9)))
        return false;
    soma = 0;
    for (i = 0; i < 10; i ++)
        soma += parseInt(CPF.charAt(i)) * (11 - i);
    resto = 11 - (soma % 11);
    if (resto == 10 || resto == 11)
        resto = 0;
    if (resto != parseInt(CPF.charAt(10)))
        return false;
    return true;
 }
 
 function replaceAll( str, replacements ) {
    for ( i = 0; i < replacements.length; i++ ) {
        var idx = str.indexOf( replacements[i][0] );

        while ( idx > -1 ) {
            str = str.replace( replacements[i][0], replacements[i][1] );
            idx = str.indexOf( replacements[i][0] );
        }

    }

    return str;
}

// returns true if received param_name is in invalid Name list
function formValidation_isInvalidName( param_name ){		
    var invalidName = ['aaa','bbb','ccc','ddd','eee','fff','ggg','hhh','iii','jjj','kkk','lll','mmm','nnn','ooo','ppp','qqq','rrr','sss','ttt','uuu','vvv','www','xxx','yyy','zzz'];
    for( var i=0; i < invalidName.length; ++i ){
        if( param_name.indexOf(invalidName[i]) > -1 ) return true;
    }
    return false;
}

// returns true if recived rg is in invalid rg list
function formValidation_isInvalidRG( rg ){		
    var invalidRG = ['00.000.000-0','11.111.111-1','22.222.222-2','33.333.333-3','44.444.444-4','55.555.555-5','66.666.666-6','77.777.777-7','88.888.888-8','99.999.999-9'];
    for( var i=0; i < invalidRG.length; ++i ){
        if( rg == invalidRG[i] ) return true;
    }
    return false;
}

function formValidation_isInvalidCep( cep ){		
    var invalidCep = ['00000-000','11111-111','22222-222','33333-333','44444-444','55555-555','66666-666','77777-777','88888-888','99999-999'];
    for( var i=0; i < invalidCep.length; ++i ){
        if( cep == invalidCep[i] ) return true;
    }
    return false;
}
// returns true if recived cep1 is in invalid cep1 list
function formValidation_isInvalidCep1( cep1 ){		
    var invalidCep1 = ['11111','22222','33333','44444','55555','66666','77777','88888','99999','12345'];
    for( var i=0; i < invalidCep1.length; ++i ){
        if( cep1 == invalidCep1[i] ) return true;
    }
    return false;
}

// returns true if recived cep1 is in invalid cep1 list
function formValidation_isInvalidCep2( cep2 ){		
    var invalidCep2 = ['111','222','333','444','555','666','777','888','999','123'];
    for( var i=0; i < invalidCep2.length; ++i ){
        if( cep2 == invalidCep2[i] ) return true;
    }
    return false;
}


// valid date types => dd/mm/YYYY dd-mm-YYYY
function formValidation_validateDate( strValue, format ) {
    if( format == 'EN' ){
        var objRegExp = /^\d{4}(\-|\/|\.)\d{2}\1\d{2}$/
        if( !objRegExp.test(strValue) )
            return false;
            
        var strSeparator = strValue.substring(4,5);
        var arrayDate = strValue.split(strSeparator);
        return formValidation_validateDateDays( arrayDate[2], arrayDate[1], arrayDate[0] );
    }
    if( format == 'PT' ){
        var objRegExp = /^\d{2}(\-|\/|)\d{2}\1\d{4}$/
         
        //check to see if in correct format
        if(!objRegExp.test(strValue))
            return false; //doesn't match pattern, bad date
        
        var strSeparator = strValue.substring(2,3);
        var arrayDate = strValue.split(strSeparator);
        return formValidation_validateDateDays( arrayDate[0], arrayDate[1], arrayDate[2] );
    }
    if( format == 'BR' ){
        var objRegExp = /^\d{2}(\/|)\d{2}\1\d{4}$/
         
        //check to see if in correct format
        if(!objRegExp.test(strValue))
            return false; //doesn't match pattern, bad date
        
        var strSeparator = strValue.substring(2,3);
        var arrayDate = strValue.split(strSeparator);
        return formValidation_validateDateDays( arrayDate[0], arrayDate[1], arrayDate[2] );
    }		
    return false; //any other values, bad date
}


function formValidation_validateDateDays( day_val, month_val, year_val ){
    
    //create a lookup for months not equal to Feb.
    var arrayLookup = { '01' : 31,'03' : 31, 
                        '04' : 30,'05' : 31,
                        '06' : 30,'07' : 31,
                        '08' : 31,'09' : 30,
                        '10' : 31,'11' : 30,
                        '12' : 31 }
                        
    var intDay = parseInt( day_val, 10 ); 
        
    //check if month value and day value agree
    if(arrayLookup[month_val] != null) {
      if(intDay <= arrayLookup[month_val] && intDay != 0)
        return true; //found in lookup table, good date
    }
        
    // verify biss year
    var intMonth = parseInt(month_val,10);
    if (intMonth == 2) { 
        var intYear = parseInt(year_val);
         if (intDay > 0 && intDay < 29) {
            return true;
        }
        else if (intDay == 29) {
             if ((intYear % 4 == 0) && (intYear % 100 != 0) || (intYear % 400 == 0)) {
                // year div by 4 and ((not div by 100) or div by 400) ->ok
                 return true;
             }   
        }
    }
    return false;
}

function formValidation_isValidCNPJ(val) {

    if (val.match(/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/) != null) {
        var val1 = val.substring(0, 2);
        var val2 = val.substring(3, 6);
        var val3 = val.substring(7, 10);
        var val4 = val.substring(11, 15);
        var val5 = val.substring(16, 18);

        var i;
        var number;
        var result = true;

        number = (val1 + val2 + val3 + val4 + val5);

        s = number;

        c = s.substr(0, 12);
        var dv = s.substr(12, 2);
        var d1 = 0;

        for (i = 0; i < 12; i++)
            d1 += c.charAt(11 - i) * (2 + (i % 8));

        if (d1 == 0)
            result = false;

        d1 = 11 - (d1 % 11);

        if (d1 > 9) d1 = 0;

        if (dv.charAt(0) != d1)
            result = false;

        d1 *= 2;
        for (i = 0; i < 12; i++) {
            d1 += c.charAt(11 - i) * (2 + ((i + 1) % 8));
        }

        d1 = 11 - (d1 % 11);
        if (d1 > 9) d1 = 0;

        if (dv.charAt(1) != d1)
            result = false;

        return result;
    }
    return false;
}