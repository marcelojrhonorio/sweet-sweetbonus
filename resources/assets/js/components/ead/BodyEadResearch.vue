<template>
  <div class="area-form">
    <form id="survey" method="post" action="/ead/research" data-smk-form>
      <input type="hidden" name="_token" :value="csrf">
      <div class="section-title">
        <h3>Fatos e indicadores sobre o nível de escolaridade do Brasil</h3>
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

import Question from './QuestionEadResearch.vue';

export default {
  name: 'body-ead',
  components: {
    Question
  },
  beforeCreate() {

  },
  created() {
    this.$http.get('https://api.sweetmedia.com.br/api/ead/v1/frontend/research-question').then(res => {
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
</style>