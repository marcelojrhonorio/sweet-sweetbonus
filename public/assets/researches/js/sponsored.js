(function($) {
    const Sponsored = {
        start: function() {
            this.$form                 = $('[data-smk-form]');
            this.$alert                = $('[data-form-register-alert]');
            this.$alertSuccess         = $('[data-form-alert-success]');

            this.$btn                  = $('[btn-submit-research]');
            this.$questionsOneAnswer   = $('[data-questions-one-answer]');
            this.$questionsMoreAnswer  = $('[data-questions-more-answer]'); 

            this.$alert = $('[data-alert-danger]');
            
            // All questions from API.
            this.$questions = [];
            this.$research;
            this.$researches_id;
            this.$questions_id;
            this.$research_questions = [];
            this.$question_options = [];
            this.$options = [];
            this.$researchMiddlePages = [];
            this.$middlePages = [];
            this.$customers_id;

            this.$questionIndex = 0;
            this.$finishResearch = false;

            this.$progress = $('[data-research-progress]');

            this.$balloon0 = $('[data-balloon-percent0]');
            this.$balloon25 = $('[data-balloon-percent25]');
            this.$balloon50 = $('[data-balloon-percent50]');
            this.$balloon75 = $('[data-balloon-percent75]');
            this.$balloon100 = $('[data-balloon-percent100]');
            this.$balloonIcon0 = $('[data-balloon-percent0-icon]');
            this.$balloonIcon25 = $('[data-balloon-percent25-icon]');
            this.$balloonIcon50 = $('[data-balloon-percent50-icon]');
            this.$balloonIcon75 = $('[data-balloon-percent75-icon]');
            this.$balloonIcon100 = $('[data-balloon-percent100-icon]');

            this.$initialQuestions = {
              inicialized      :  false,
              questions_number :  0,
              question_index :  0,
            };

            this.$next = $('[data-btn-next]');

            this.$currentResearchQuestion = $('[data-research-current-question]');

            this.$loader = $('[data-research-loader]');            
      
            this.bind();
          },

          bind: function() {    
            this.loadPage();
            this.$next.on('click', this.onNextClick.bind(this));
            this.$btn.on('click', $.proxy(this.onBtnSubmitClick, this));
          },

          onNextClick(event) {
            event.preventDefault();

            var answer = $("input[name='question-" + this.$questions_id + "']:checked").val();

            if(!answer) {
              answer = $("input[name='question-" + this.$questions_id + "[]']:checked").toArray().map(function(check) { 
                return $(check).val(); 
            });
            }

            if(!answer || (0 == answer.length)) {
                this.$alert.removeClass("sr-only");
            } else {
                this.$alert.addClass("sr-only");
                
                //salvar resposta 
                Sponsored.saveAnswer(this.$questions_id, answer);                
            }
          },

          saveAnswer(question, answer) {

            this.$currentResearchQuestion.fadeOut("slow", function() {   

                var dataAnswer;
                var options_id;
                var middle_pages_id = null;

                //Verificação para questões que permitem mais de uma resposta.
                if(Array.isArray(answer)) 
                {                  
                    for (let index = 0; index < answer.length; index++) 
                    {                      
                        if(answer[index].indexOf("middle") != -1) {
                          dataAnswer = answer[index].split('middle');
                          options_id = dataAnswer[0];
                          middle_pages_id = dataAnswer[1];
                        } else {
                          dataAnswer = answer[index].split('-');
                          options_id = dataAnswer[1];
                        }

                        var last_index = false;

                        if(index == answer.length-1) {
                          last_index = true;
                        }
                       
                        Sponsored.registerAnswer(question, options_id, middle_pages_id, true, last_index);   
                         
                    }
                } else {
                  if(answer.indexOf("middle") != -1) {
                    dataAnswer = answer.split('middle');
                    options_id = dataAnswer[0];
                    middle_pages_id = dataAnswer[1];
                  } else {
                    dataAnswer = answer.split('-');
                    options_id = dataAnswer[1];
                  }

                  Sponsored.registerAnswer(question, options_id, middle_pages_id, false, false);  
                }  
            });

          },

          registerAnswer(question, options_id, middle_pages_id, is_array, last_index) {

            const save_answer = $.ajax({
              method: 'POST',
              url: '/research/save-research-answer',
              contentType: 'application/json',
              data: JSON.stringify({
                _token : $('meta[name="csrf-token"]').attr('content'),
                researches_id : Sponsored.$researches_id, 
                customers_id : Sponsored.$customers_id, 
                question : question, 
                options_id : options_id, 
                middle_pages_id : middle_pages_id, 
                finish_research: Sponsored.$finishResearch,
                is_array: is_array,
                last_index: last_index,
              }),
            });

            if(!Sponsored.$finishResearch) 
            {
              if(is_array && !last_index) {
                return;
              }

              Sponsored.$questionIndex++;
              Sponsored.renderQuestions(this.$questionIndex);
            } else {
                if(is_array && !last_index) {
                  return;
                }

                Sponsored.$loader.removeClass('sr-only');
                $('[data-btn-next]').addClass("sr-only");
                $('.progress').addClass("sr-only");
                window.location.href = "/research/final/research/" + middle_pages_id;
            }                 
        
            save_answer.done($.proxy(this.onSaveAnswerSuccess, this));  
            save_answer.fail($.proxy(this.onSaveAnswerFail, this)); 

          },

          onSaveAnswerSuccess: function (data) { 
            if(data.success) {
                
            }
          },
            
          onSaveAnswerFail: function (error) {
            console.log(error)
          },

          loadPage: function(event) {
            var url = (window.location.href).split('/');
            var final_url = url[url.length-2];
            var customers_id = url[url.length-1];

            Sponsored.$loader.removeClass('sr-only');
            
            const search_data = $.ajax({
              method: 'POST',
              url: '/research/get-data-research',
              contentType: 'application/json',
              data: JSON.stringify({
                _token : $('meta[name="csrf-token"]').attr('content'),
                final_url : final_url, 
                customers_id : customers_id, 
              }),
            });
        
            search_data.done($.proxy(this.onSearchDataSuccess, this));  
            search_data.fail($.proxy(this.onSearchDataFail, this));
           
          },

          onSearchDataSuccess: function (data) {
            if(data.success) {
                var data_research = data.data;

                this.$questions = data_research.questions;
                this.$research = data_research.research;
                this.$researches_id = data_research.research.id;
                this.$research_questions = data_research.research_questions;
                this.$question_options = data_research.question_options;
                this.$options = data_research.options;
                this.$researchMiddlePages = data_research.researchMiddlePages;
                this.$middlePages = data_research.middlePages;
                this.$customers_id = data_research.customers_id;

                Sponsored.$loader.addClass('sr-only');
                $('[data-btn-next]').removeClass("sr-only");

                //verificar se já finalizou a pesquisa, e qual a ultima questão
                Sponsored.verifyStatusResearch(this.$customers_id, this.$researches_id);
            }
            
          },

          onSearchDataFail: function (error) {
            console.log(error)
          },

          renderQuestions() {            

            // Verify if research is finished.
            if (this.$questions.length-1 === (this.$questionIndex)) {
                Sponsored.$finishResearch = true;
            }

            // Clear data.
            $('.question-title').remove();
            $('.extra-information').remove();
            $('.answer').remove();

            // Hide loader.
            this.$loader.addClass('sr-only');

            var question = this.$questions[Sponsored.$questionIndex];
            var questions_number = this.$questions.length;

            if (false === this.$initialQuestions.inicialized) {
              this.$initialQuestions.inicialized = true;
              this.$initialQuestions.questions_number = questions_number; 
              this.$initialQuestions.question_index = Sponsored.$questionIndex; 
            } 

            /**
             * Render progress bar.
             */
            else {             
              questions_number = Sponsored.$questionIndex;

              this.$initialQuestions.question_index = Sponsored.$questionIndex; 

              //verificar calculo
              const percent = (questions_number * 100) / this.$questions.length;

              this.$initialQuestions.questions_number = this.$initialQuestions.questions_number - 1;

              $('[data-research-progress]').css({width: percent + '%'});
              this.changeBalloons(percent);
            }

            this.$questions_id = question.id;
            
            this.$currentResearchQuestion.append("<h4 class='question-title' style='padding-top: 3px;color:#475a4e'>" + question.description + " *</h4><br>");

            if(question.extra_information) {
                this.$currentResearchQuestion.append("<p class='extra-information'>" + question.extra_information + "</p>") 
            }

            $('[total-questions]').val(this.$question_options.length);

            for (let index = 0; index < this.$question_options.length; index++) 
            {
                if(this.$question_options[index][0].questions_id == question.id) 
                {
                    for (let index2 = 0; index2 < this.$question_options[index].length; index2++) 
                    {
                        for (let index3 = 0; index3 < this.$options.length; index3++) 
                        {
                            if(this.$options[index3].id == this.$question_options[index][index2].options_id)
                            {
                                var flag = '';

                                for (let index4 = 0; index4 < this.$researchMiddlePages.length; index4++) 
                                {
                                    if(this.$researchMiddlePages[index4].questions_id == question.id)
                                    {
                                        for (let index5 = 0; index5 < this.$middlePages.length; index5++) 
                                        {
                                            if(this.$middlePages[index5].id == this.$researchMiddlePages[index4].middle_pages_id)
                                            {
                                                if(this.$options[index3].id == this.$researchMiddlePages[index4].options_id)
                                                {
                                                    flag = this.$options[index3].id;

                                                    if(1 == question.one_answer) {
                                                        this.$currentResearchQuestion.append("<div class='answer' style='padding-left:5px;font-size:15px;'><input type='radio' id='option-" + this.$options[index3].id + "' name='question-"+ question.id + "' value='" + this.$options[index3].id + "middle" + this.$middlePages[index5].id + "' required> <label style='font-weight:400;color: #666;' for='option-" + this.$options[index3].id + "'> " +  this.$options[index3].description + "</label>");
                                                    } else {
                                                        this.$currentResearchQuestion.append("<div class='answer' style='padding-left:5px;font-size:15px;'><input type='checkbox' id='option-" + this.$options[index3].id + "' name='question-"+ question.id + "[]' value='" + this.$options[index3].id + "middle" + this.$middlePages[index5].id + "' required> <label style='font-weight:400;color: #666;' for='option-" + this.$options[index3].id + "'> " +  this.$options[index3].description + "</label>");
                                                    }
                                                }
                                            }                                            
                                        }
                                    } 
                                }
                               
                                if(flag != this.$options[index3].id)
                                {
                                    if(1 == question.one_answer) {
                                        this.$currentResearchQuestion.append("<div class='answer' style='padding-left:5px;font-size:15px;'><input type='radio' id='option-" + this.$options[index3].id + "' name='question-"+ question.id + "' value='option-" + this.$options[index3].id + "' required> <label style='font-weight:400;color: #666;' for='option-" + this.$options[index3].id + "'> " +  this.$options[index3].description + "</label>");
                                    } else {
                                        this.$currentResearchQuestion.append("<div class='answer' style='padding-left:5px;font-size:15px;'><input type='checkbox' id='option-" + this.$options[index3].id + "' name='question-"+ question.id + "[]' value='option-" + this.$options[index3].id + "' required> <label style='font-weight:400;color: #666;' for='option-" + this.$options[index3].id + "'> " +  this.$options[index3].description + "</label>");
                                    }
                                }
                            }
                        }                        
                    }
                }               
            }

            this.$currentResearchQuestion.fadeIn("slow");
          },

          /**
           * Change balloons colors. 
           */
          changeBalloons: function (percent) {

            if (percent >= 1 && percent < 25) {
              this.$balloon0.css("background-color", '#60c6c8');
              this.$balloonIcon0.css("color", '#60c6c8');
            }

            if (percent >= 25 && percent < 50) {
              this.$balloon25.css("background-color", '#60c6c8');
              this.$balloonIcon25.css("color", '#60c6c8');
            }

            if (percent >= 50 && percent < 75) {
              this.$balloon25.css("background-color", '#60c6c8');
              this.$balloonIcon25.css("color", '#60c6c8');
              this.$balloon50.css("background-color", '#60c6c8');
              this.$balloonIcon50.css("color", '#60c6c8');
            }

            if (percent >= 75 && percent < 100) {
              this.$balloon25.css("background-color", '#60c6c8');
              this.$balloonIcon25.css("color", '#60c6c8');
              this.$balloon50.css("background-color", '#60c6c8');
              this.$balloonIcon50.css("color", '#60c6c8');
              this.$balloon75.css("background-color", '#60c6c8');
              this.$balloonIcon75.css("color", '#60c6c8');
            }

            if (percent >= 100) {
              this.$balloon25.css("background-color", '#60c6c8');
              this.$balloonIcon25.css("color", '#60c6c8');
              this.$balloon50.css("background-color", '#60c6c8');
              this.$balloonIcon50.css("color", '#60c6c8');
              this.$balloon75.css("background-color", '#60c6c8');
              this.$balloonIcon75.css("color", '#60c6c8');
              this.$balloon100.css("background-color", '#60c6c8');
              this.$balloonIcon100.css("color", '#60c6c8');
            }
          },

          verifyStatusResearch(customers_id, researches_id)
          {
              const verify = $.ajax({
                method: 'POST',
                url: '/research/verify-research',
                contentType: 'application/json',
                data: JSON.stringify({
                  _token : $('meta[name="csrf-token"]').attr('content'),
                  researches_id : researches_id, 
                  customers_id : customers_id, 
                }),
              });
          
              verify.done($.proxy(this.onVerifySuccess, this));  
              verify.fail($.proxy(this.onVerifyFail, this));
          },

          onVerifySuccess: function (data) {
            if(data.success) {               

                //Se usuário não finalizou a pesquisa, continuar da questão onde parou.
                if('not_answered' == data.data.status) {
                  if(0 != data.data.qtdAnsweredQuestions) {
                    Sponsored.$questionIndex = data.data.qtdAnsweredQuestions;
                  }                  
                } else {

                  //Se usuário já finalizou a pesquisa porém está respondendo novamente,
                  //verifica-se se todas as questões foram respondidas. Caso positivo, inicia-se da primeira.
                  //Caso contrário inicia-se da questão onde parou.

                  if(data.data.qtdAnsweredQuestions == data.data.qtdResearcheQuestion) {
                    Sponsored.$questionIndex = 0;
                  } else {
                    Sponsored.$questionIndex = data.data.qtdAnsweredQuestions;
                  }
                }

                //atualizar progress bar
                const perc = (Sponsored.$questionIndex * 100) / this.$questions.length;

                $('[data-research-progress]').css({width: perc + '%'});
                this.changeBalloons(perc);

                Sponsored.renderQuestions();
            }            
          },

          onVerifyFail: function (error) {
            console.log(error)
          },

          onBtnSubmitClick: function(event) {           

            var answers = [];
            var dataOneAnswer = this.$questionsOneAnswer.val();
            var questionsOne = dataOneAnswer.split('|');

            for (let index = 0; index < questionsOne.length; index++) {               
                if(questionsOne[index]) {
                    var value = this.$form.find('input[name="question-'+questionsOne[index]+'"]:checked').val();                                      
                    answers.push(value);
                }
            }

            var dataMoreAnswer = this.$questionsMoreAnswer.val();
            var questionMore = dataMoreAnswer.split('|');

            for (let index = 0; index < questionMore.length; index++) {               
                if(questionMore[index]) {
                      var value = this.$form.find('input[name="question-'+questionMore[index]+'[]"]:checked').val();
                      answers.push(value);
                    }  
            }            

            var flag = true;

            for (let index = 0; index < answers.length; index++) {                        
                if(!answers[index]) {                    
                    event.preventDefault();

                    flag = false;

                    this.$alert.removeClass('sr-only');
                    this.$alert.text('Por favor, verifique se todas as questões estão respondidas.');
                    return;
                }
            }

            if(flag) {
                this.$alert.addClass('sr-only');
                this.$alertSuccess.removeClass('sr-only');
                this.$alertSuccess.text('Dados enviados com sucesso.');
            }
          },
    }
  
    $(function() {
        Sponsored.start();
    });
  })(jQuery);  