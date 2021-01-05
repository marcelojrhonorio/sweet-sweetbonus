<template>
  <div class="area-form">
    <form id="survey" method="post" action="/quiz/research?id=3" data-smk-form>
      <input type="hidden" name="_token" :value="csrf">
      <div class="section-title">
        <h3>Responda corretamente a três perguntas e habilite-se a ganhar diversos prêmios.</h3>
        <hr>
      </div>
        <question
        v-for="question in questions"
        v-bind:key="question.id"
        v-bind:description="question.description"
        v-bind:id="question.id"
        v-bind:one_answer="question.one_answer"
        v-bind:options="question.research_options"
        v-bind:extra="question.extra_information">
        </question>
      <button class="btn-submit" type="submit">Enviar</button>
    </form>
  </div>
</template>

<script>

import Question from './QuestionQuizResearch.vue';

export default {
  name: 'body-quiz3',
  components: {
    Question
  },
  beforeCreate() {

  },
  created() {
    this.$http.get('https://api.sweetmedia.com.br/api/quiz/v1/frontend/research-question').then(res => {
      this.questions = res.body.data;
    })
  },
  beforeMount() {

  },
  data () {
    return {
      questions:[],
      options:[],
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  },
}
</script>

<style lang="scss">
body {
    background-repeat: no-repeat;
    background-position: center top;
    background-attachment: fixed;
    background-color: #F9FDFE;
    font-family: 'Helvetica', sans-serif;
    background-size: 1350px 730px;
}

.form-header {
    width: 100%;
    padding: 25px;
    margin: 0 auto;
    background-color: #3785c3;
    background-size: 100%;
}

.form-header .title {
    max-width: 560px;
    width: 100%;
    padding-left: 50px;
}

.form {
    max-width: 1150px;
    width: 100%;
    padding: 25px;
    margin: 0 auto;
}

.form .form-wrapper {
    max-width: 560px;
    width: 100%;
}

.title {
    margin: 25px 0;
}

.title img {
    height: 74px;
    float: left;
    margin-right: 15px;
}

.title h1 {
    color: #ffffff;
    font-family: 'Oswald', sans-serif;
    font-size: 37px;
    text-transform: uppercase;
}

.title p {
    font-size: 20px;
    font-family: 'Roboto', sans-serif;
    font-weight: 300;
}

.extra-information {
    font-size: 12px;
}

.section-title {
    width: 100%;
    float: left;
    margin-bottom: 20px;
}

h3 {
    font-size: 20px;
    font-family: 'Roboto', sans-serif;
    font-style: italic;
    font-weight: 900;
}

hr {
    width: 100px;
    float: left;
    margin:0;
    border: 0;
    border-top: 2px solid #322e2e;
}


[type="radio"]:checked,
[type="radio"]:not(:checked),
[type="checkbox"]:checked,
[type="checkbox"]:not(:checked){
    position: absolute;
    left: -9999px;
}
[type="radio"]:checked + label,
[type="radio"]:not(:checked) + label,
[type="checkbox"]:checked + label,
[type="checkbox"]:not(:checked) + label
{
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
}
[type="radio"]:checked + label:before,
[type="radio"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before,
[type="checkbox"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 20px;
    border: 1px solid #322e2e;
    border-radius: 2px;
    background: #fbfeff;
}
[type="radio"]:checked + label:after,
[type="radio"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after,
[type="checkbox"]:not(:checked) + label:after {
    content: '';
    width: 14px;
    height: 14px;
    background: #322e2e;
    position: absolute;
    top: 3px;
    left: 3px;
    border-radius: 2px;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}
[type="checkbox"]:checked + label:after,
[type="checkbox"]:not(:checked) + label:after {
    content: "\2713";
    background: #ffffff;
    font-size: 23px;
    font-weight: bold;
    color: #322e2e;
    margin-left: -2px;
}
[type="radio"]:not(:checked) + label:after,
[type="checkbox"]:not(:checked) + label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}
[type="radio"]:checked + label:after,
[type="checkbox"]:checked + label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
}

.form-group {
    font-size: 16px;
    width:100%;
    float: left;
}

h4 {
    font-size: 16px;
    font-weight: 500;
}

.radio-label {
    margin-right: 20px;
    float: left;
}

.radio-label label {
    font-weight: 400 !important;
    font-size: 16px;
}

.conditional-inputs {
    width: 100%;
    float: left;
    padding: 5px 0 0 25px;
    border-left: 1px solid #322e2e;
}

.conditional-inputs .radio-label {
    width: 100%;
}

::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    #aaaaaa;
    font-style: italic;
    font-weight: 400;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:    #aaaaaa;
    font-weight: 400;

    font-style: italic;
    opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:    #aaaaaa;
    font-style: italic;
    font-weight: 400;
    opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
    color:    #aaaaaa;
    font-style: italic;
    font-weight: 400;
}
::-ms-input-placeholder { /* Microsoft Edge */
    color:    #aaaaaa;
    font-style: italic;
    font-weight: 400;
}

input[type="text"], select {
    max-width: 325px;
    width: 100%;
    padding: 5px 10px;
    border: 1px solid #322e2e;
    border-radius: 2px;
    background: #fff;
    font-size: 14px;
    height: 40px;
    font-weight: 700;
}

.conditional-inputs select,
.conditional-inputs input[type="text"] {
    max-width: 300px;
}

button {
    margin-top: 30px;
    max-width: 325px;
    text-align: center;
    width: 100%;
    height: 80px;
    padding: 20px 30px;
    font-style: italic;
    font-size: 21px;
    background: none;
    border-radius: 2px;
    border: 1px solid #322e2e;
    color: #322e2e;
    line-height: 40px;
}

button:hover,
button:focus {
    background: #322e2e;
    color: #fff;
}

button span {
    font-size: 50px;
    font-weight: 300;
    font-family: initial;
}

.error {
    color: red;
    font-style: italic;
    font-size: 14px;
}

.error-field {
    border-color: red;
    color: red;
}

.error-text {
    color: red;
}

@media (max-width: 991px) {
    body {
        background-attachment: initial;
        background-size: 100%;
    }

    .title {
        margin: 10px 0 20px;
        min-height: 44px;
    }

    .title img {
        width: 60px;
        height: auto;
    }

    .title h1 {
        font-size: 20px;
    }
}
.area-thanks {
    display: none;
}
.dim {
    height: 100%;
    width: 100%;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 10000 !important;
    background-color: black;
    filter: alpha(opacity=75);
    -khtml-opacity: 0.75;
    -moz-opacity: 0.75;
    opacity: 0.75;
    text-align: center;
    display: none;
}

.dim img {
    top: 50%;
    left: 50%;
    margin: -32px 0 0 -32px;
    position: fixed;
}
</style>