/**
 * @returns {sweet}
 */
var sweet = sweet || {};

/*Exception
 *
 *var error = new Error('erro);
 *error.name = "nome do erro";
 *throw error;
 *
 *Error Name      Description
 *EvalError       An error in the eval() function has occurred.
 *RangeError      Out of range number value has occurred.
 *ReferenceError  An illegal reference has occurred.
 *SyntaxError     A syntax error within code inside the eval() function has occurred.
 *                All other syntax errors are not caught by try/catch/finally, and will
 *                trigger the default browser error message associated with the error.
 *                To catch actual syntax errors, you may use the onerror event.
 *TypeError       An error in the expected variable type has occurred.
 *URIError        An error when encoding or decoding the URI has occurred
 *                (ie: when calling encodeURI()).
 **/
sweet.msgException = {
    msg: function (error, call) {
        if (console && console.log) {
            console.log(
                'ERRO TIPO JS (%s), \n' +
                'MSG ERRO: (%s),    \n' +
                'LINHA: (%d),       \n' +
                'ARQUIVO: (%o)      \n' +
                'STACK: (%S)        \n' +
                'CALL: (%S)          ',
                error.name,
                error.message,
                error.lineNumber,
                error.fileName,
                error.stack,
                call);
        }
    }
};


sweet.common = {

    allowEdit: true,
    clickNewButton: false,
    divWait: $('#modal-loading'),
    token: null,
    timeOut: 2000,
    url: '',
    returnData: null,
    parseMail: /\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i,
    parseDate: /(0[0-9]|[12][0-9]|3[01])[-\.\/](0[0-9]|1[012])[-\.\/][0-9]{4}/,

    formToJSON: function (fields) {
        return JSON.stringify(fields);
    },

    setToken: function (token) {
        this.token = token;
    },

    setTimeOut: function(value) {
        this.timeOut = value;
    },

    header: function () {
        return ({
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        });
    },

    keyValidate: function (data, key) {
        return (data[key] !== undefined ? data[key] : '');
    },

    keyValidateDate: function (data, key) {
        return (data[key] !== undefined && (data[key].indexOf('0001-01-01 00:00:00') < 0 && data[key].indexOf('0001-01-01') < 0 ) ? moment(data[key], 'YYYY-MM-DD').format("DD/MM/YYYY") : '');
    },

    onlyNumber: function (value) {
        return value.replace(/([^\d*])/g, '');
    },

    formatterMoney: function (value) {
        var result = 0;

        result = value.replace('.', ''),
            result = result.replace(',', '.');

        return result;
    },

    formatterDate: function (data) {
        if (data.indexOf('<input') !== -1) {
            return data;
        }
        var date = moment(data),
            month = date.get('month') + 1,
            formatted = (date.get('date') > 9 ? date.get('date') : "0" + date.get('date') ) + "/" + (month > 9 ? month : "0" + month) + "/" + date.get('year');

        return data == '0001-01-01' || formatted == '01/1/2001' ? '' : formatted;
    },

    download: function (url) {
        window.location.href = url;
    },

    validateFullName: function (value) {
        var parse = /[A-z][ ][A-z]/;
        return parse.test(value);
    },

    validadeCEP: function (cep) {
        var er = /^[0-9]{2}.[0-9]{3}-[0-9]{3}$/;

        cep = cep.replace(/^s+|s+$/g, '');

        if (er.test(cep)) {
            return true
        }

        return false;
    },

    validateDate: function (date) {
        var
            year = '',
            month = '',
            day = '',
            month30Days = ['04','06','09','11'],
            februaryDay = '',
            validateMonth = '',
            validateYear = '',
            regex = '',
            validate = date.replace(/[^\d\/\.]/gi, '');

        if (validate && validate.length == 10) {
            year = date.substr(6),
            month = date.substr(3,2),
            day = date.substr(0,2),

            validateMonth = /(0[1-9])|(1[0-2])/.test(month),
            validateYear = /(19[1-9]\d)|(20\d\d)|2100/.test(year),
            regex = new RegExp(month),
            februaryDay = year % 4? 28: 29;

            if (validateMonth && validateYear) {
                if (month == '02') {
                    return (day >= 1 && day <= februaryDay);
                } else if (regex.test(month30Days)) {
                    return /((0[1-9])|([1-2]\d)|30)/.test(day);
                } else {
                    return /((0[1-9])|([1-2]\d)|3[0-1])/.test(day);
                }
            }
        }
        return false                           // se inválida :(
    },

    message: function(type, message)
    {
        toastr[type](message);
    },

    iconStatusApp: function(data) {
        if (data == 1) {
            return '<span class="fa fa-circle" style="color: #7CFC00;" title="Sim"></span>';
        }
        return '<span class="fa fa-circle" style="color: #B22222;" title="Não"></span>';
    },

    querystringToHash: function(queryString) {
        var j, q;
        q = queryString.replace(/\?/, "").split("&");
        j = {};
        $.each(q, function(i, arr) {
            arr = arr.split('=');
            return j[arr[0]] = arr[1];
        });
        return j;
    },

    hashToQueryString: function(hash) {
        return $.param(hash);
    },

    isMobile: function() {
        var userAgent = navigator.userAgent.toLowerCase();

        //(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) window.location = b

        if( userAgent.search(/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i) != -1) {
            return true;
        }
        return false;
    },

    isFacebookApp: function() {
        var ua = navigator.userAgent || navigator.vendor || window.opera;
        ua = ua.toUpperCase();

        if (ua.indexOf('FBAN') > -1 || ua.indexOf('FBAV') > -1 || ua.indexOf('FBIOS')  > -1  || ua.indexOf('FBDV')  > -1
            || ua.indexOf('FBBV')  > -1  || ua.indexOf('FBMD')  > -1  || ua.indexOf('FBSN')  > -1  || ua.indexOf('FBLC')  > -1
            || ua.indexOf('FBSV')  > -1  || ua.indexOf('FBSS')  > -1  || ua.indexOf('FBCR')  > -1  || ua.indexOf('FBID')  > -1 ) {
            return true;
        }
        return false;
    },

    buttons: {
        delete: function (id, title, icon) {
            var
                title =  (!sweet.validate.isNull(title) ? title : 'Excluir'),
                icon =  (!sweet.validate.isNull(icon) ? icon : 'fa-trash');
            return '<button class="btn btn-xs btn-danger delete" data-id="' + id + '"><i class="fa ' + icon + '" aria-hidden="true" title="' + title + '"></i></button>';
        },
        edit: function (params) {

            var options = [];

            if (sweet.validate.isObject(params)) {
                $.each(params, function (key, value) {
                    options += key + '="' + value + '" ';
                });
            }

            return ('<button class="btn btn-xs btn-primary edit" ' + options + '><i class="fa fa-pencil" aria-hidden="true" title="Editar"></i></button>');
        },
        save: function () {
            return '<button class="btn btn-xs save" style="background-color: #449D44; border-color: #449D44; color: #fff;"><i class="fa fa-check" aria-hidden="true" title="Salvar"></i></button>';
        },
        update: function (id) {
            return '<button data-id="' + id + '" class="btn btn-xs update" style="background-color: #449D44; border-color: #449D44; color: #fff;"><i class="fa fa-check" aria-hidden="true" title="Atualizar"></i></button>';
        },
        cancel: function () {
            return '<button class="btn btn-xs btn-danger cancel"><i class="fa fa-times" aria-hidden="true" title="Cancelar"></i></button>';
        }
    },

    crud: {
        read: function (option) {
            try {

                var
                    requestType = (sweet.validate.isNull(option.type)) ? 'POST' : option.type,
                    dataType = (sweet.validate.isNull(option.dataType)) ? 'json' : option.dataType,
                    timeOut  = (sweet.validate.isNull(option.timeOut)) ? sweet.common.timeOut : option.timeOut;

                return ($.ajax({
                    url: sweet.common.url.concat(option.endpoint),
                    type: requestType,
                    dataType: dataType,
                    cache: false,
                    contentType: "application/json; charset=utf-8",
                    data: sweet.common.formToJSON(option.params),
                    headers: sweet.common.header(),
                    timeout: timeOut,
                }));

            } catch (e) {
                sweet.msgException.msg(e, 'sweet.common.read.save');
            }
        },

        save: function (option) {
            try {
                //jQuery.support.cors = true;
                var
                    requestType = (sweet.validate.isNull(option.type)) ? 'POST' : option.type,
                    dataType = (sweet.validate.isNull(option.dataType)) ? 'json' : option.dataType,
                    timeOut  = (sweet.validate.isNull(option.timeOut)) ? sweet.common.timeOut : option.timeOut;

                return ($.ajax({
                    url: sweet.common.url.concat( option.endpoint),
                    type: requestType,
                    dataType: dataType,
                    //crossDomain: true,
                    //async: true,
                    cache: false,
                    contentType: "application/json; charset=utf-8",
                    data: sweet.common.formToJSON(option.params),
                    headers: sweet.common.header(),
                    timeout: timeOut,
                }));

            } catch (e) {
                sweet.msgException.msg(e, 'sweet.common.crud.save');
            }
        },

        delete: function (option) {

            try {

                swal({
                    title: 'Você deseja realmente excluir?',
                    text: '',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não, cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    buttonsStyling: true,
                    preConfirm: function () {
                       return new Promise((resolve, reject) => {
                            $.ajax({
                                url: option.route,
                                type: option.type,
                                dataType: option.datatype,
                                data: {'id': option.id },
                                timeout: sweet.common.timeOut,
                                cache: false,
                                contenType: 'application/x-www.form-urlencoded;charset=UTF-8'
                            }).fail(function(error) {
                               reject('Ocorreu algum erro ou ID não informado corretamente.');
                            }).done(function(data) {
                                option.table.ajax.reload();
                                resolve();
                            }).always(function(data) {
                                console.log(data);
                            });
                        });
                    }

                }).then((result) => {
                     if (result.value) {
                        swal('', 'Exclusão realizada com sucesso.', 'success');
                    }
                }, function(error) {
                    swal('', error, 'error');
                });

            } catch (e) {
                sweet.msgException.msg(e, 'sweet.common.crud.delete');
            }
        }
    }
};

