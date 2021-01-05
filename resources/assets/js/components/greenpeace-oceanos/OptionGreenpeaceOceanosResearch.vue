<template>

  <p class="radio-label" required>
    <input v-if="one_answer==1" type="radio" v-bind:id="'option-'+id" v-bind:name="'question-'+question_id" v-bind:value="'option-'+id" required>
    <input v-if="one_answer==0" type="checkbox" v-bind:id="'option-'+id" v-bind:name="'question-'+question_id+'[]'" v-bind:value="'option-'+id">
    <label v-bind:for="'option-'+id">{{description}}</label>
  </p>  

</template>
<script>
export default {
  props:['description', 'id', 'question_id','one_answer'], 
}
</script>