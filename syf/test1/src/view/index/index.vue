<template>
  <div class="indexPage">
    <div @click="goUpload">上传页面</div>
    <p>---------------</p>
    <div @click="goRead">浏览页面</div>
  </div>
</template>
<script>
export default {
  data(){
    return{

    }
  },
  created(){

  },
  methods:{
    goUpload(){
      this.$router.push({ path: '/upLoad' }); 
    },
    goRead(){
      this.$router.push({ path: '/read' }); 
    },
  }
}
</script>
<style lang="scss">
.indexPage{

}
</style>


