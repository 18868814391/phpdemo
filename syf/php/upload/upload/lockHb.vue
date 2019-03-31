<template>
  <div class="lockHb-page">
    <div class="lp-head">
      <van-icon name="arrow-left" @click="back" />
      <div>红贝锁定区</div>
      <div style="width:30px;height:10px;"></div>      
    </div>



<van-list
  v-model="loading"
  :finished="finished"
  @load="onLoad"
  :immediate-check="false"
>
    <div class="lp-item" v-for="(item,index) in list" :key="index">
      <div class="lp-item-t1">{{item.remark}}:{{item.freeze_score}}</div>
      <div class="lp-item-t2">{{item.create_time}}</div>
      <div class="lp-item-box2" v-if="secArray[index]>0&&item.status!=33&&item.status==0">{{timArray[index]=='已锁定'?'已锁定':'剩余时间：'+timArray[index]}}</div>
      <div class="lp-item-box1" v-if="item.status==0&&secArray[index]<=0" @click="lingqu(item.id)">领取</div>
      <div class="lp-item-box3" v-if="item.status==1">已领取</div>
      <div class="lp-item-box3" v-if="secArray[index]>0&&item.status==33&&item.status==0">已锁定</div>
    </div>
</van-list>

    <div v-if="finished" style="text-align:center;margin:10px 0;color:rgba(85, 85, 85, 1);">—— 我是有底线的 ——</div>


    <!-- <div class="lp-item">
      <div class="lp-item-t1">商品购买-获得红贝：100.00</div>
      <div class="lp-item-t2">2018-09-08 18:00:12</div>
      <div class="lp-item-box1">领取</div>
    </div>
    <div class="lp-item">
      <div class="lp-item-t1">商品购买-获得红贝：100.00</div>
      <div class="lp-item-t2">2018-09-08 18:00:12</div>
      <div class="lp-item-box2">剩余时间：20:20:20</div>
    </div>
    <div class="lp-item">
      <div class="lp-item-t1">商品购买-获得红贝：100.00</div>
      <div class="lp-item-t2">2018-09-08 18:00:12</div>
      <div class="lp-item-box3">已领取</div>
    </div>
    <div class="lp-item">
      <div class="lp-item-t1">商品购买-获得红贝：100.00</div>
      <div class="lp-item-t2">2018-09-08 18:00:12</div>
      <div class="lp-item-box3">已锁定</div>
    </div>             -->
 
  </div>
</template>
<script>
import { Icon, Toast,List } from 'vant';
export default {
  components: {
    [Icon.name]: Icon,
    [Toast.name]: Toast,
    [List.name]: List,
  },
  data(){
    return{
      list:'',
      loading: false,
      finished: false,       
      start_page:0,
      timArray:[],//倒计时
      secArray:[],//剩余的秒数
      timObj:'',
      lockOn:false,
      step:1000,//倒计时秒数，当锁定时，改为9999999999
      offday:'',//2100年到今天的时间
      offSeconds:'',//2100年到今天的秒数
    }
  },
  created(){
      let self=this;
      //计算2100年到今天的天数；
      self.timeGet();
      
			self.$store.dispatch('getUserMsg', {
				"token": self.$store.state.user.token,
			}).then((d) => {
				if (d.errcode == 0) {
          self.usermsg = d.data;
          console.log('红贝冻结提示',self.usermsg.lock_freeze_score)
          if(self.usermsg.lock_freeze_score==1){
            self.lockOn=true;
            self.step=9999999999999;
          }
          self.getMsg();
				} else {
					Toast('个人信息获取失败:'+d.errmsg);
				}
			}).catch((d) => {
				Toast('网络延迟,个人信息获取失败,请稍后再试');
      }); 
  },
  beforeDestroy(){
    clearInterval(this.timObj); //关闭    
  },  
  methods:{
    back(){
      window.history.go(-1);
    },
    timeGet(){
      let self=this;
      //计算2100年到今天的天数；精确到秒2333
      let currentTime = Date.now();
      let targetTime = (new Date(2098, 11, 31, 23, 59, 59)).getTime();
      let offsetTime = targetTime - currentTime;
      let offsetDays = Math.floor(offsetTime / (3600 * 24 * 1e3));
      self.offday=offsetDays;
      self.offSeconds=offsetTime/1000;      
    },
    lingqu(d){
      if(this.lockOn){
        this.$router.push({ path: '/adminFreeze' }); 
      }else{
        let self=this;
        Toast.loading({
          mask: true,
          message: '提交中...'
        });
        self.$store.dispatch('hbGetout', {
          "token": self.$store.state.user.token,
          "receive_id":d,      
        }).then((d) => {
          Toast.clear();
          if (d.errcode == 0) {
            Toast.success({
              mask: true,
              message: '操作成功'
            });
            setTimeout(function(){
              window.location.reload();
            },1000)
          } else {
            Toast(d.errmsg);
          }
        }).catch((d) => {
          Toast(d.errmsg);
        });         
      }         
    },
    onLoad() {
      // 异步更新数据
      console.log('开启上啦加载')
      let self=this;
      self.start_page++;
      this.start_page=this.start_page;
      setTimeout(() => {
      let self = this;
      self.$store.dispatch('getLockHb', {
        "token": self.$store.state.user.token,
        "start_page":self.start_page,
        "pages":10,
      }).then((d) => {
        Toast.clear();
        if (d.errcode == 0) {
          self.list = self.list.concat(d.data.list);
          console.log('加载拼接后的',self.list);
          self.timArray=[];
          self.secArray=[];
          self.list.forEach(function(v,i,a){ //利用vue无法监控数组对象的缺陷，已经开始的倒计时不被重置
            if((v.rest.day*24*60*60+v.rest.hour*60*60+v.rest.min*60+v.rest.sec)>=self.offSeconds){
              self.timArray.push('已锁定');
            }else{
              self.timArray.push(v.rest.day+'天'+' '+v.rest.hour+':'+v.rest.min+':'+v.rest.sec);
            }
            self.secArray.push(v.rest.day*24*60*60+v.rest.hour*60*60+v.rest.min*60+v.rest.sec);
          })          
          self.loading = false; 
                  if (d.data.is_next==0) {
                    self.finished = true;
                  }           
        } else {
          Toast(d.errmsg); 
        }
      }).catch((d) => {
        Toast('网络延迟，信息获取失败，请稍后再试');
      });
      }, 500);
    },     
    getMsg(){
      let self=this;
			self.$store.dispatch('getLockHb', {
        "token":self.$store.state.user.token,
        "start_page": self.start_page,
        "pages": "10"        
			}).then((d) => {
				if (d.errcode == 0) {
          self.list = d.data.list;
          self.list.forEach(function(v,i,a){
            if((v.rest.day*24*60*60+v.rest.hour*60*60+v.rest.min*60+v.rest.sec)>=self.offSeconds){
              self.timArray.push('已锁定');
            }else{
              self.timArray.push(v.rest.day+'天'+' '+v.rest.hour+':'+v.rest.min+':'+v.rest.sec);
            }
            self.secArray.push(v.rest.day*24*60*60+v.rest.hour*60*60+v.rest.min*60+v.rest.sec);
          })     
          self.timeObject();
          self.timObj=setInterval(function(){
            // console.log(self.timArray,self.secArray)
            //为了精确到秒，随时更新
            self.timeGet();         
            self.timeObject();
          },self.step)          
				} else {
					Toast('信息获取失败:'+d.errmsg);
				}
			}).catch((d) => {
				Toast('网络延迟,信息获取失败,请稍后再试');
			});
    }, 
    timeObject(){
      let self=this;
      self.secArray.forEach(function(v,i,a){
      //self.secArray[i]=self.secArray[i]-1;
      self.$set(self.secArray, i, self.secArray[i]-1);
        if(self.secArray[i]<=1){
          self.$set(self.timArray, i, '已到期');  
        }else{
          let Day = Math.floor(v*1 / (60 * 60 * 24));
          let Hour = Math.floor((v*1 - Day * 24 * 60 * 60) / 3600);
          let Minute = Math.floor((v*1 - Day * 24 * 60 * 60 - Hour * 3600) / 60);
          let Second = Math.floor(v*1 - Day * 24 * 60 * 60 - Hour * 3600 - Minute * 60)
          if(v*1>=self.offSeconds*1){
            self.$set(self.timArray, i, '已锁定');
          }else{
            self.$set(self.timArray, i, Day+'天'+' '+Hour+':'+Minute+':'+Second);
          }
          self.list[i].rest.day= Day;
          self.list[i].rest.hour= Hour;
          self.list[i].rest.min= Minute;
          self.list[i].rest.sec=Second;
        }
      })      
    },    
  },  
}
</script>
<style lang="less">
.lockHb-page{
  .lp-head{
    width: 100%;
    height: 44px;
    background: white;
    padding: 0 18px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size:16px;
    font-family:PingFang-SC-Regular;
    color:rgba(53,53,53,1);
    margin-bottom:10px; 
  }
  .lp-item{
    width: 100%;
    height:77px;
    background: white;
    padding: 15px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    border-bottom:2px solid #f4f4f4; 
    &-box1{
      padding: 0 10px;
      height:31px;
      background:rgba(230,0,18,0.05);
      border-radius:4px; 
      text-align: center;
      line-height: 31px;
      font-size:14px;
      font-family:PingFangSC-Regular;
      font-weight:400;
      color:rgba(230,0,18,1);    
      position: absolute;
      right:15px;
      top:35px;       
    }
    &-box2{
      padding: 0 10px;
      height:31px;
      background:rgba(150,150,150,0.1);
      border-radius:4px; 
      text-align: center;
      line-height: 31px;
      font-size:14px;
      font-family:PingFangSC-Regular;
      font-weight:400;
      color:rgba(85,85,85,1);   
      position: absolute;
      right:15px;
      top:35px;      
    }
    &-box3{
      padding: 0 10px;
      height:31px;
      background:rgba(248,248,248,1);
      border-radius:4px; 
      text-align: center;
      line-height: 31px;
      font-size:14px;
      font-family:PingFangSC-Regular;
      font-weight:400;
      color:rgba(153,153,153,1);  
      position: absolute;
      right:15px;
      top:35px;       
    }
    &-t1{
      font-size:14px;
      font-family:PingFangSC-Semibold;
      font-weight:600;
      color:rgba(51,51,51,1);
      width: 300px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    &-t2{
      font-size:12px;
      font-family:PingFangSC-Regular;
      font-weight:400;
      color:rgba(153,153,153,1);
    }
  }
}
</style>


