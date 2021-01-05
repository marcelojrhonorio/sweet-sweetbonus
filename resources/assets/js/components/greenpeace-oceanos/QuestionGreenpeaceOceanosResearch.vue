<template>
  <div class="conditional-inputs" v-bind:id="id">
    <div class="form-group">
      <h4 v-html="description">{{description}} *</h4>
      <p class="extra-information">{{extra}}</p>
        <Option
        v-for="option in options"
        v-bind:key="option.id"
        v-bind:description="option.description"
        v-bind:id="option.id"
        v-bind:question_id="option.question_id"
        v-bind:one_answer="one_answer">
        </Option>                       
      <p class="radio-label error"></p>
    </div>
  </div>    
</template>
<script>

import Option from './OptionGreenpeaceOceanosResearch.vue';

export default {
  props: ['options','description','id', 'question_id', 'one_answer', 'extra'],
  components: {
    Option
  },
}
</script>