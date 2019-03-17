<template>
  <div class="register-page">
    <div class="rebox">
      <el-input v-model="admin" placeholder="请输入账户"></el-input>
      <el-input v-model="Thename" placeholder="请输入昵称"></el-input>
      <el-input placeholder="请输入登陆密码" v-model="code" show-password></el-input>
    </div>
    <el-button type="primary" plain @click="submit">提交</el-button>
  </div>
</template>
<script>
import { register } from '@/api';
import md5 from 'js-md5'
export default {
  data(){
    return{
      admin:'',
      Thename:'',
      code:'',
    }
  },
  created(){

  },
  methods:{
    submit(){
      const self=this;
      register({
        admin:self.admin,
        Thename:self.Thename,
        code:md5(self.code),
      }).then((d)=>{
        console.log(d)
        console.log(d.data.Version_code)
      }).catch(()=>{

      })
    }
  },
}
</script>
<style lang="less">
.register-page{
  .rebox{
    width:30%;
  }
}
</style>


