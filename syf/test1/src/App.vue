<template>
  <div id="app">
      <div>1.index</div>
      <div @click="goLogin">2.login</div>
      <div>3.register</div>
      <!-- <keep-alive >
        <router-view v-if="$route.meta.keepAlive"></router-view>
      </keep-alive> -->
      <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'app',
  data(){
    return{

    }
  },
  created(){

  },
  methods:{
    goLogin(){
      this.$router.push({path: '/login'});  
    }
  },
}
</script>

<style>
</style>
