<template>
  <div class="orderconfirmPage">
    <div v-if="addlist.length==0" class="GoNewadd" @click="goNewAdd">
      <div>新建收货地址，保证商品顺利送达！</div>
      <img src="../../../assets/img/morefun.png" alt="">
    </div>
    <div v-for="item in addlist" v-if="item.maid==addid" :key="item.maid" class="orderconfirm-man" @click="goAdd">
      <!-- <img class="orderconfirm-man-loc" src="../../../assets/img/location.png" alt=""> -->
      <div class="orderconfirm-man-left">
        <div class="orderconfirm-man-left-2">
          <div class="orderconfirm-man-left-2-box">
            <span v-if="item.name">
              {{ item.name }}&nbsp;&nbsp;
            </span>
            <span style="color:rgba(153,153,153,1);">
            {{ item.tel }}
            </span>
            <!-- <span class="orderconfirm-man-left-2-moren">
              默认
            </span> -->
          </div>
          <div class="orderconfirm-man-left-2-add">
            收货地址：{{ item.full_name }}
          </div>
        </div>
      </div>
      <div class="orderconfirm-man-right">
        <van-icon name="arrow" size="12px" />
      </div>
    </div>
    <div class="caidai"></div>
    <div class="caidai2">商品信息</div>

    <div v-for="(item,index) in cartdata" v-if="item.list!='empty'" :key="index" class="cart-store">
      <!-- <div class="cart-store-name">
				<img width="20px" height="20px" @click="goStore(item.shop.id)" :src="item.shop.logo_url" alt="" style="margin-left:12px">
				<span class="cart-store-name-3" @click="goStore(item.shop.id)">{{item.shop.name}}</span>
				<van-icon class="cart-store-name-4" @click="goStore(item.shop.id)" name="arrow" size="10px" />
			</div> -->
      <div v-for="(i,index) in item.list" v-if="i!='empty'" :key="index" class="cart-store-goods">
        <img :src="i.img_url" class="cart-store-goods-img" alt="" @click="goGoods(i.item_id)">
        <div class="cart-store-goods-detail">
          <div class="cart-store-goods-detail-1">
            {{ i.title }}
          </div>
          <div class="cart-store-goods-detail-2">
            规格：{{ i.value_names.replace(/\s+/g,'/') }}
          </div>
          <div class="cart-store-goods-detail-3">
            <span>
              <span class="cart-store-goods-detail-4">¥{{i.price}}
              </span>
            </span>
            <span class="cart-store-goods-detail-2">
                &times;{{parseInt(i.num)}}
            </span>
          </div>
        </div>
        <div class="cart-store-goods-line" />
      </div>
    </div>
    <div class="trans">
      <div>共{{ item_data.length }}件商品</div>
      <div class="trans-p">
        小计：<span style="color:rgba(196, 13, 0, 1);font-weight:400;">¥
          {{postage_sum?Number(tp-postage_sum*1).toFixed(2):Number(tp).toFixed(2)}}
        </span>
      </div>
      <div class="cart-store-goods-line" />
    </div> 
    <div class="buyer-msg">
      <div class="buyer-msg-inp2">
        买家留言：
      </div>
      <textarea v-model="remark" class="buyer-msg-inp" type="text" placeholder="请输入，最多140字" @input="inpfun()">

      </textarea>
      <div class="zishu">{{zishu}}/140</div>
      <div class="cart-store-goods-line" />
    </div>       
    <div class="trans">
      <div>运费</div>
      <div v-if="postage_sum" class="trans-p">
        ￥{{ postage_sum }}
      </div>
      <div v-else>
        包邮
      </div>
      <div class="cart-store-goods-line" />
    </div>
    <!-- <div class="trans"> 
      <div>不希望TA看到带有价格的发货</div>
      <div>
        <van-switch v-model="display_price" size="24px" active-color="#d7452c" />
      </div>
      <div class="cart-store-goods-line" />
    </div>     -->
    <van-cell :title="'发票'" :value="is_bill==1?'电子发票':'不开发票'" is-link @click="goBill"/>
    <div class="blankBox"></div>
    <div class="trans" v-if="point>=1000"> 
      <div>可以使用{{pointCan}}积分抵扣{{pointRmb}}元</div>
      <div>
        <van-switch v-model="jifenC" size="24px" active-color="#d7452c" @change="usePoint(jifenC)" />
      </div>
      <div class="cart-store-goods-line" />
    </div>
    <div class="trans" v-else>
      <div>积分</div>
      <div class="trans-p">
        {{`共${point}积分，满1000积分可用`}}
      </div>
      <div class="cart-store-goods-line" />
    </div>   

    <!-- <van-cell :title="coupon_title+couponlist.length+'张'" :value="coupon_number>0?`满${M_number}元减${coupon_number}元`:'未使用'" is-link @click="openCoupon" /> -->

    <div class="trans" @click="openCoupon">
      <div>
        优惠券
      </div>
      <img class="cup-img" src="../../../assets/img/morefun.png" alt="">
      <div class="cup-alive" v-if="coupon_number<=0">
        {{couponlist.length}}张可用
      </div>
      <div class="cup-num" v-if="coupon_number>0">
        已减{{coupon_number}}元
      </div>
      <div class="cart-store-goods-line" />
    </div>  
      
    <div class="trans">
      <div>可用余额￥{{myMoney>0?myMoney:'0.00'}}，本单支付<span style="color:rgba(215,30,69,1);">￥{{(paypMoney*1).toFixed(2)}}</span></div>
      <div v-if="myMoney*1>0">
        <van-switch v-model="yueC" size="24px" active-color="#d7452c" @change="useMoney(yueC)" />
      </div>
      <div class="cart-store-goods-line" />
    </div> 
    <div class="blankBox"></div>
    <div class="trans">
      <div class="trans-wx1">
        <img src="../../../assets/img/we-pay.png" alt="">
        微信支付
      </div>
      <div class="trans-wx2">
        <img src="../../../assets/img/doint2.png" alt=""> 
      </div>
    </div>

    <div class="ordersubmit">
      <div class="ordersubmit-sub" @click="toOrdersuccess">
        去下单
      </div>
      <div class="ordersubmit-total2">
        ￥{{ moneyCount>=0?(moneyCount*1).toFixed(2):'0.00' }}
      </div>
      <div class="ordersubmit-total">
        应付金额：
      </div>
      <div class="ordersubmit-tip">
        请在1天内完成付款
      </div>
    </div>

    <van-popup v-model="serviceshow" position="bottom" style="border-radius:20px 20px 0px 0px;padding-bottom:50px;max-height:85%;">
      <nm-coupon-list
        :type_code="'1'"
        :coupons="couponlist"
        :chosen-coupon="chosenCoupon"
        @change="onChangeCoupon" 
      />
    </van-popup>
    <van-button
      v-if="serviceshow"
      :text="'不使用优惠券'"
      size="large"
      class="nm-coupon-list_close"
      @click="onChangeCoupon(-1)"
    />

    <div class="zhegai" v-if="showKeyboard"></div>

    <div class="passcon" v-if="showKeyboard">
      <div class="passcon-t1">请输入支付密码</div>
      <van-password-input :value="value" info="密码为 6 位数字" @focus="showKeyboard = true" v-if="showKeyboard" />
    </div>

    <van-number-keyboard :show="showKeyboard" @input="onInput" @delete="onDelete" @blur="showKeyboard = false" />

  </div>
</template>
<script>
import md5 from 'js-md5';
import { Icon, Toast, popup, Dialog, Cell, Button,Switch,PasswordInput, NumberKeyboard } from 'vant'
import NmCouponList from '@/components/nm-coupon-list'
import request from '@/utils/request'
import { getToken } from '@/utils/auth' // 验权
import { orderConfirmt, getAdd,getPoint,getMoney,passCheck } from '@/api'
export default {
  components: {
    [NmCouponList.name]: NmCouponList,
    [Cell.name]: Cell,
    [Switch.name]: Switch,
    [Button.name]: Button,
    [Icon.name]: Icon,
    [Toast.name]: Toast,
    [popup.name]: popup,
    [Dialog.name]: Dialog,
    [PasswordInput.name]: PasswordInput,
    [NumberKeyboard.name]: NumberKeyboard,
  },
  data() {
    return {
      token: getToken(),
      zishu:0,//留言字数
      showKeyboard: false,//数字键盘
      value: '',//数字键盘输入的值
      passWord:'',//支付密码，6位数字，没有加密
      moneyCount:'',//进行抵扣操作后变动的金额，也是传给后端的最终下单金额.初始值为商品金额加上邮费
      coupon_title: '可用猎米优惠券',
      jifenC:false,//是否使用积分
      point:'',//积分数量
      pointCan:'',//可以抵扣的积分
      pointRmb:'',//可以抵扣积分对应的人名币
      yueC:false,//是否使用余额
      myMoney:'',//我的余额
      display_price:false,//发货时是否隐藏价格
      paypMoney:0.00,//在本单中将被花费的余额
      is_bill:0,//是否开票，只要进入这个页面，默认1  不然0
      bill_type:1,//个人还是单位 个人1  单位2
      danName:'',//单位名称
      danNum:'',//纳税人识别号
      phone:'',//手机号
      mail:'',//邮箱 
      invoice:{
        "invoice_content":"商品明细",
        "invoice_type":"电子发票",
        "type":'',
        "company_name":'',
        "company_code":'',
        "phone":'',
        "mail":''        
      },     
      coin: 0,
      coupon: 0,
      coupon_number: 0,//减的值
      M_number:0,//满的值
      cuid: '',//优惠券编号
      couponlist: [],
      chosenCoupon: -1,
      serviceshow: false, // 优惠券栏目显示布尔值
      cartdata: '',
      pricelist: [],
      sum: [],
      postage: [], // 各店邮费
      postage_sum: 0, // 总邮费
      tp: '', // 商品总价加上邮费
      tp2:'',//商品总价
      addlist: [],
      addid: '', // 要传给后端的地址id
      item_data: [], // 要传给后端的商品组合数据
      // applyshow:true,//支付方式页面显示布尔值
      pay_order_no: '', // 提交订单后返回的订单号
      pay_amount: '', // 提交订单后返回的总金额
      applytype: '', // 支付方式 1微信  2支付宝
      remark: ''
    }
  },
  created() {
    const self = this
    this.gotPoint();
    this.gotMoney();
    this.getBill();
    if(this.is_bill!=1){
      this.invoice='';
    }
    self.cartdata = JSON.parse(window.localStorage.getItem('cartdata'))
    console.log('购物车数据', self.cartdata)
    const arr11 = []
    self.cartdata.forEach(function(val, ind) {
      let flag = false
      self.cartdata[ind].list.forEach(function(v, i) {
        // 如果商品都是empty，删除该店铺
        if (self.cartdata[ind].list[i] != 'empty') {
          flag = true
        }
      })
      if (flag) {
        arr11.push(self.cartdata[ind])
      }
    })
    self.cartdata = arr11

    const lenx1 = self.cartdata.length // empty商品直接删除
    for (let q = 0; q < lenx1; q++) {
      const lenx2 = self.cartdata[q].list.length
      for (let z = 0, biao = true; z < lenx2; biao ? z++ : z) {
        if (self.cartdata[q].list[z] == 'empty') {
          self.cartdata[q].list.splice(z, 1)
          biao = false
        } else {
          biao = true
        }
      }
    }

    self.cartdata.forEach(function(val, ind) {
      // 将empty数据剔除后计算价格
      let sum = 0
      self.cartdata[ind].list.forEach(function(v, i) {
        sum =
					sum +
					self.cartdata[ind].list[i].price * self.cartdata[ind].list[i].num
      })
      self.pricelist.push(sum.toFixed(2))
    })

    let totalsum = 0
    self.cartdata.forEach(function(val, ind) {
      // 计算商品件数
      self.cartdata[ind].list.forEach(function(v, i) {
        totalsum =
					totalsum +
					Number(self.cartdata[ind].list[i].price) *
					Number(self.cartdata[ind].list[i].num)
      })
    })
    self.tp = totalsum
    self.tp2=totalsum
    self.cartdata.forEach(function(val) {
      // 生成将要传递给后台的数据
      val.list.forEach(function(v) {
        const obj = { ivid: '', num: '', cart_id: '', remark: '' }
        obj.ivid = v.ivid
        obj.num = Number(v.num)
        obj.cart_id = v.cart_id
        self.item_data.push(obj)
      })
    })

    self.cartdata.forEach(function(val, ind) {
      // 随便塞数字，生成对应商店邮费数组
      self.postage.push(0)
      // 将各个商店邮费信息按其最大值填入
      val.list.forEach(function(v) {
        if (v.postage > self.postage[ind]) {
          self.postage[ind] = v.postage
        }
      })
      // 累加全部商店邮费信息
      self.postage_sum = Number(self.postage_sum) + Number(self.postage[ind])
    })
    self.tp = (self.tp + self.postage_sum).toFixed(2)
    self.moneyCount=self.tp
    self.getAddList()
    self.getCoinCouponInfo()
    self.getCouponList()
  },
  methods: {
    getCoinCouponInfo() {
      const self = this
      request({
        method: 'post',
        url: '/member/user-coin-api/get-my-coin',
        data: {
          token: self.token
        }
      })
        .then(function(res) {
          Toast.clear()
          if (res.errcode === 0) {
            self.coin = res.data.coin
            self.coupon = res.data.coupon
          } else {
            Toast(res.errmsg)
          }
        })
        .catch(d => {
          Toast.clear()
          Toast(d.errmsg)
        })
    },
    inpfun(){ //监控输入的留言是是否超了
      if(this.remark.length>140){
        Toast('留言数量超过了140个字');
        this.remark=this.remark.substring(0,139);
      }
      this.zishu=this.remark.length;
    },
    getCouponList() {
      const self = this
      // 获取验证码
      request({
        method: 'post',
        url: '/coupon/coupon-api/index',
        data: {
          token: self.token,
          start_page: 0,
          pages: 100,
          status: '1'
        }
      }).then(function(res) {
        Toast.clear()
        if (res.errcode === 0) {
          for (let i = 0; i < res.data.list.length; i++) {
            if (Number(self.tp) > Number(res.data.list[i].condition_num)) {
              self.couponlist.push(res.data.list[i])
            }
          }
        } else {
          Toast(res.errmsg)
        }
      }).catch((d) => {
        Toast.clear()
      })
    },
    goStore(d) {
      this.$router.push({ path: '/store', query: { shop_id: d }})
    },
    goGoods(d) {
      this.$router.push({ path: '/goods', query: { goods_id: d }})
    },
    goAdd() {
      this.$router.push({ path: '/address', query: { type: 1 }})
    },
    goNewAdd() {
      this.$router.push({ path: '/newadd' })
    },
    goBill(){
      this.$router.push({ path: '/myBill',query: { is_bill: this.is_bill,bill_type:this.bill_type,danName:this.danName,danNum:this.danNum,phone:this.phone,mail:this.mail} })
    },
    backtoCart() {
      history.go(-1)
    },
    openCoupon() {
      if (this.couponlist.length > 0) {
        this.serviceshow = true
      }
    },
    onChangeCoupon(index) { //改变选择优惠券
      const self = this
      if (index == -1) {
        if(!this.yueC){ //如果余额支付没有打开
          self.moneyCount=self.moneyCount*1+self.coupon_number*1
          self.cuid = ''
          self.coupon_number = 0
          self.M_number=0          
        }else{
          self.moneyCount=self.moneyCount*1+self.coupon_number*1;
          this.paypMoney=this.paypMoney*1+self.coupon_number*1;
          self.cuid = ''
          self.coupon_number = 0
          self.M_number=0  
        }
        //如果积分抵扣未打开，则重置积分抵扣
        // if(!this.jifenC){
        //   let d1=(parseInt(self.tp2/2))*1000;
        //   if(d1<=self.point){ //可以按最大值抵扣了
        //     self.pointCan=d1;
        //     self.pointRmb=parseInt(self.tp2/2);
        //   }else{ //按所拥有的1000整倍的积分抵扣
        //     self.pointCan=parseInt(self.point/1000)*1000;
        //     self.pointRmb=self.pointCan/1000;
        //   }          
        // }
        // if(self.moneyCount<=self.pointRmb){
        //   self.pointRmb=self.moneyCount;
        //   self.pointCan=self.pointRmb*1000;
        // }
      } else {
        if(!this.yueC){ //如果余额支付没有打开
          self.moneyCount=self.moneyCount+self.coupon_number;
          self.cuid = self.couponlist[index].cu_id
          self.coupon_number = Number(self.couponlist[index].discount_num)
          self.M_number = JSON.parse((self.couponlist[index].rule)).m          
          self.moneyCount=self.moneyCount-self.coupon_number;
        }else{ //如果余额支付被打开了
          self.moneyCount=self.moneyCount+self.coupon_number;
          this.paypMoney=this.paypMoney*1+self.coupon_number*1;
          self.cuid = self.couponlist[index].cu_id
          self.coupon_number = Number(self.couponlist[index].discount_num)
          self.M_number = JSON.parse((self.couponlist[index].rule)).m          
          self.moneyCount=self.moneyCount-self.coupon_number;        
          this.paypMoney=this.paypMoney-self.coupon_number;
        }        
        // if(self.moneyCount<0){ //唯一会出现负数的情况
        //  self.moneyCount=0 
        // }
        //如果积分抵扣未打开，则开始影响积分抵扣的值
        // if(!this.jifenC){
        //   if(this.moneyCount<=this.pointRmb){ //如果可以使用积分抵扣剩下全部的钱了
        //     if(this.moneyCount>0){
        //       this.pointRmb=parseInt(this.moneyCount/1);
        //       this.pointCan=this.pointRmb*1000;
        //     }else{
        //       this.pointRmb=0;
        //       this.pointCan=0;
        //     }
        //   }
        // }        
      }
      self.chosenCoupon = index
      self.serviceshow = false
    },
    applySel(d) {
      this.applytype = d
    },
      //moneyCount:'',//进行抵扣操作后变动的金额，也是传给后端的最终下单金额.初始值为商品金额加上邮费
      // jifenC:false,//是否使用积分
      // point:'',//积分数量
      // pointCan:'',//可以抵扣的积分
      // pointRmb:'',//可以抵扣积分对应的人名币
      // yueC:false,//是否使用余额
      // myMoney:'',//我的余额 
      //paypMoney:'0.00',//在本单中将被花费的余额

    usePoint(d){ //开启积分支付
      const self=this;
      console.log(d);
      if(d){ //打开
        if(!this.yueC){ //如果余额支付没有打开
          this.moneyCount=this.moneyCount-this.pointRmb;
        }else{ //如果余额支付被打开了
          this.paypMoney=this.paypMoney-this.pointRmb;
          this.moneyCount=this.moneyCount+this.pointRmb;
          this.moneyCount=this.moneyCount-this.pointRmb;
        }
      }else{//关闭
        if(!this.yueC){//如果余额支付没有打开
          this.moneyCount=this.moneyCount*1+this.pointRmb*1;
        }else{
          this.paypMoney=this.paypMoney+this.pointRmb;
          this.moneyCount=this.moneyCount+this.pointRmb;
        }
      }
    },
    useMoney(d){  //开启余额支付
      const self=this;
      console.log(d);
      if(d){ //打开
        if(this.myMoney*1>=this.moneyCount*1){ //余额充足
          this.paypMoney=this.moneyCount;
          this.moneyCount=0;
        }else{  //余额不足
          this.paypMoney=this.myMoney;
          this.moneyCount=this.moneyCount-this.paypMoney;
        }
        //如果积分抵扣未打开，则开始影响积分抵扣的值
        // if(!this.jifenC){
        //   if(this.moneyCount<=this.pointRmb){ //如果可以使用积分抵扣剩下全部的钱了
        //     this.pointRmb=parseInt(this.moneyCount/1);
        //     this.pointCan=this.pointRmb*1000;
        //   }
        // }
      }else{ //关闭
        this.moneyCount=this.moneyCount*1+this.paypMoney*1;
        this.paypMoney=0;

        //如果积分抵扣未打开，重置积分抵扣相关数值
        // if(!this.jifenC){
        //   let d1=(parseInt(self.tp2/2))*1000;
        //   if(d1<=self.point){ //可以按最大值抵扣了
        //     self.pointCan=d1;
        //     self.pointRmb=parseInt(self.tp2/2);
        //   }else{ //按所拥有的1000整倍的积分抵扣
        //     self.pointCan=parseInt(self.point/1000)*1000;
        //     self.pointRmb=self.pointCan/1000;
        //   }
        //   if(self.moneyCount<=self.pointRmbpointRmb){
        //     self.pointRmb=self.moneyCount;
        //     self.pointCan=self.pointRmb*1000;
        //   }                    
        // }
      }
    },
    onInput(key) {
      let self = this;
      this.value = (this.value + key).slice(0, 6);
      console.log(key);
      if (this.value.length == 6) { //验证交易密码是否正确
        Toast.loading({
          mask: true,
          message: '验证密码中...'
        });
        passCheck({
          token: self.$store.state.user.token,
          password:md5(self.value)
        }).then(d=>{
          Toast.clear()
          if(d.errcode==0){
            self.paySystem()
          }else{
            Toast('密码验证失败,请重新输入密码')
            self.value=''
          }
        }).catch(d=>{
          Toast('密码验证失败,请重新输入密码')
          self.value=''
        })
        
      }
    },
    onDelete() {
      this.value = this.value.slice(0, this.value.length - 1);
    },    
    toOrdersuccess() {
      const self=this;
      if(self.yueC){ //没有使用余额的话，直接进行核算支付
        self.showKeyboard=true
      }else{ //使用了余额，需要进行密码输入
        self.paySystem()
      }
    },
    paySystem(){
      const self = this
      if (self.addid) {
        Toast.loading({
          mask: true,
          message: '提交中...'
        })
        let point=0;
        let money=0;
        if(self.jifenC){
          point=self.pointCan
        }
        if(self.yueC){
          money=self.paypMoney
        }
        orderConfirmt({
          token: self.$store.state.user.token,
          item_data: self.item_data,
          amount: self.moneyCount*1>0?self.moneyCount:'0',
          // amount: self.moneyCount,
          display_price:String(self.display_price*1),
          remark: self.remark,
          pay_score:point,
          pay_amount:money,
          cuid: self.cuid,
          address_id: self.addid,
          password:md5(self.value),
          invoice:self.invoice,          
        }).then(d => {
          Toast.clear()
          if (d.errcode == 0) { //判断是否还需要额外支付
            if(self.moneyCount>0){
              sessionStorage.setItem('PayInfo_create_time', d.data.create_time.replace(/-/g, '/'))
              sessionStorage.setItem('PayInfo_end_time', d.data.end_time.replace(/-/g, '/'))
              sessionStorage.setItem('PayInfo_pay_amount', d.data.pay_amount)
              sessionStorage.setItem('PayInfo_pay_order_no', d.data.pay_order_no)
              sessionStorage.setItem('CartDataError', JSON.stringify(self.cartdata)) //万一支付失败，跳转失败页面展示商品图片用
              self.$router.push({
                path: '/applyConfirm'
              }) // 订单起始时间，放在地址              
            }else{
              self.$router.replace(
                {
                  path: '/ordersuccess', query: { amount: self.moneyCount}
                }
              )              
            }
          } else {
            Toast(d.errmsg)
          }
        })
          .catch(d => {
            Toast(d.errmsg)
          })
      } else {
        Dialog.confirm({
          title: '提示',
          message: '您需要先设置一个收货地址'
        })
          .then(() => {
            self.$router.push({ path: '/newadd' })
          })
          .catch(() => {
            // on cancel
          })
      }
    },
    getAddList() {
      // 获取地址列表
      const self = this
      getAdd({
        token: self.$store.state.user.token,
        start_page: 0,
        pages: 999
      }).then(d => {
        if (d.errcode == 0) {
          self.addlist = d.data.list
          if(self.addlist[0]){
            self.addid = self.addlist[0].maid;//无论如何，先把第一个地址填入，以免无默认地址的情况
          }
          self.addlist.forEach(function(v) {
            // 将默认地址存入作为收件地址
            if (v.is_top == 1) {
              self.addid = v.maid
            }
          })
        } else {
          Toast(d.errmsg)
        }
      }).catch(d => {
        Toast('网络延迟,地址信息获取失败,请稍后再试')
      })
    },
    gotPoint() {
      // 获取积分
      // pointCan:'',//可以抵扣的积分
      // pointRmb:'',//可以抵扣积分对应的人名币
      const self = this
      getPoint({
        token: self.$store.state.user.token,
      }).then(d => {
        if (d.errcode == 0) {
          self.point = d.data.coin
          console.log(self.point,'我的积分')
          console.log('商品总价',self.tp2)
          console.log('商品总价加上邮费',self.tp)
          let d1=(parseInt(self.tp2/2))*1000;
          if(d1<=self.point){ //可以按最大值抵扣了
            self.pointCan=d1;
            self.pointRmb=parseInt(self.tp2/2);
          }else{ //按所拥有的1000整倍的积分抵扣
            self.pointCan=parseInt(self.point/1000)*1000;
            self.pointRmb=self.pointCan/1000;
          }
          console.log('可以抵扣的积分',self.pointCan,'可以抵扣积分对应的人名币',self.pointRmb)
        } else {
          Toast(d.errmsg)
        }
      }).catch(d => {
        Toast('网络延迟,信息获取失败,请稍后再试')
      })
    }, 
    gotMoney() {
      // 获取地址列表
      const self = this
      getMoney({
        token: self.$store.state.user.token,
      }).then(d => {
        if (d.errcode == 0) {
          self.myMoney=d.data.balance;
          console.log('我的推手余额',self.myMoney)
        } else {
          Toast(d.errmsg)
        }
      }).catch(d => {
        
      })
    }, 
    getBill(){//获取发票信息
      if(this.$route.query.is_bill){
        this.is_bill=this.$route.query.is_bill
      }
      if(this.$route.query.bill_type){
        this.bill_type=this.$route.query.bill_type
        this.invoice.type=String(this.$route.query.bill_type);
      }
      if(this.$route.query.danName){
        this.danName=this.$route.query.danName
        this.invoice.company_name=this.$route.query.danName;
      }
      if(this.$route.query.danNum){
        this.danNum=this.$route.query.danNum;
        this.invoice.company_code=this.$route.query.danNum;
      }
      if(this.$route.query.phone){
        this.phone=this.$route.query.phone
        this.invoice.phone=this.$route.query.phone;
      }
      if(this.$route.query.mail){
        this.mail=this.$route.query.mail
        this.invoice.mail=this.$route.query.mail;
      } 
    }      
  }

}
</script>
<style lang="scss" scoped>
.nm-coupon-list_close{
      z-index: 9999;
      left: 0;
      bottom: 0;
      position: fixed;
      font-weight: 500;
      background-color: rgba(215,30,69,1);
      color: #ffffff;
    }
.orderconfirmPage {
  padding-bottom: 150px;
  .orderconfirm-heand {
    width: 100%;
    height: 44px;
    background: white;
    box-sizing: border-box;
    padding: 0 17px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: PingFangSC-Regular;
    font-size: 0.3rem;
    letter-spacing: 1px;
    color: #353535;
    border-bottom: 1px solid #f2f2f2;
  }
  .orderconfirm-man {
    width: 100%;
    height: 80px;
    display: flex;
    padding: 0 14px;
    justify-content: space-between;
    box-sizing: border-box;
    align-items: center;
    background: white;
    position: relative;
    &-loc{
      width: 17px;
      height: 22px;
      position: absolute;
      left:15px;
    }
    &-left {
      display: flex;
      align-items: center;
      &-2 {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 14px;
        font-family: PingFangSC-Regular;
        color: #212121;
        &-box{
          font-size:18px;
          font-family:PingFangSC-Semibold;
          font-weight:600;
          color:rgba(29,30,31,1);          
          height: 17px;
          display: flex;
          align-items: center;
        }
        &-moren {
          width: 30px;
          height: 15px;
          display: inline-block;
          border: solid 1px $theme-one-color;
          border-radius: 3px;
          text-align: center;
          line-height: 15px;
          font-size: 10px;
          font-family: PingFangSC-Regular;
          color: $theme-one-color;
          margin-left:5px;
        }
        &-add {
          width:330px;
          margin-top: 10px;
          font-family: PingFangSC-Regular;
          font-size: 12px;
          color: #757575;
          word-break: break-all;
          overflow: hidden;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
        }
      }
    }
    &-right {
      color: #cacaca;
    }
  }

  .cart-store {
    width: 100%;
    box-sizing: border-box;
    background: white;
    // border-bottom: 10px solid #f4f4f4;
    &-name {
      width: 100%;
      height: 45px;
      box-sizing: border-box;
      display: flex;
      align-items: center;
      border-top: #f2f2f2 1px solid;
      border-bottom: #f2f2f2 1px solid;
      &-1 {
      }
      &-2 {
        margin-left: 15px;
        color: #998255;
      }
      &-3 {
        margin-left: 10px;
        font-family: PingFangSC-Regular;
        font-size: 13px;
        letter-spacing: 1px;
        color: #333333;
      }
      &-4 {
        margin-left: 10px;
        color: #cacaca;
      }
    }
    &-goods {
      width: 100%;
      min-height: 90px;
      box-sizing: border-box;
      display: flex;
      padding-left: 15px;
      padding-top:10px;
      padding-bottom:5px;
      position: relative;
      overflow: hidden;
      &-img{
        width: 63px;
        height: 63px;
      }
      &-line {
        width: 100%;
        height: 1px;
        border-bottom: 1px solid #f4f4f4;
        position: absolute;
        bottom: 0;
      }
      &-detail {
        margin-left:10px;
        &-1 {
          width: 270px;
          font-family: PingFangSC-Regular;
          font-size: 12px;
          word-break: break-all;
          letter-spacing: 1px;
          color: #353535;
          padding-right: 10px;
          line-height: 18px;
          overflow: hidden;
          text-overflow: ellipsis;
          display: -webkit-box;
          -webkit-box-orient: vertical;
          -webkit-line-clamp: 2;
        }
        &-2{
          font-family: PingFangSC-Regular;
          font-size: 12px;
          color: #929292;
        }
        &-3 {
          font-family: PingFangSC-Medium;
          font-size: 10px;
          color: $primary-text-color;
          display: flex;
          justify-content: space-between;
        }
        &-4 {
          font-size:16px;
        }
      }
    }
  }
  .trans {
    background-color: #ffffff;
    width: 100%;
    height: 50px;
    display: flex;
    justify-content: space-between;
    box-sizing: border-box;
    padding: 0 15px;
    align-items: center;
    overflow: hidden;
    font-family: PingFangSC-Regular;
    font-size: 14px;
    letter-spacing: 0px;
    color:rgba(29,30,31,1);
    position: relative;
    &-wx1{
      vertical-align: middle;
      img{
        height: 20px;
        vertical-align: middle;
        margin-right:5px; 
      }
    }
    &-wx2{
      img{
        height: 16px;
      }
    }
    &-p{
      height: 100%;
      display: flex;
      align-items: center;
      font-family: PingFangSC-Regular;
      font-size: 14px;
      color:rgba(153,153,153,1);
      vertical-align: middle;
      img{
        height: 12px;
        margin-left:5px; 
      }
    }
  }
  .buyer-msg {
    background-color: #ffffff;
    width: 100%;
    min-height: 35px;
    padding-left: 15px;
    padding-top:15px; 
    box-sizing: border-box;
    display: flex;
    position: relative;
    overflow: hidden;
    font-family: PingFangSC-Regular;
    font-size: 14px;
    letter-spacing: 0px;
    color: #424242;
    position: relative;
    .zishu{
      position: absolute;
      bottom:10px;
      right:16px;
      font-size:12px;
      font-family:PingFangSC-Regular;
      font-weight:400;
      color:rgba(192,192,192,1);      
    }
    &-inp2{
      margin-top:2px; 
    }
    &-inp {
      width: 250px;
      height: 90px;
      border: none;
      outline: none;
    }
  }
  .order-total {
    background-color: #ffffff;
    width: 100%;
    height: 40px;
    line-height: 40px;
    text-align: right;
    box-sizing: border-box;
    padding-right: 12px;
    font-family: PingFangSC-Regular;
    font-size: 0.2rem;
    letter-spacing: 1px;
    color: #929292;
  }
  .bill {
    width: 100%;
    height: 45px;
    box-sizing: border-box;
    padding: 0 15px;
    text-align: right;
    line-height: 45px;
    font-family: PingFangSC-Regular;
    font-size: 0.2rem;
    letter-spacing: 1px;
    color: #929292;
  }
  .ordersubmit {
    width: 100%;
    height: 45px;
    overflow: hidden;
    background: white;
    display: flex;
    align-items: center;
    flex-direction: row-reverse;
    position: fixed;
    bottom: 0;
    box-shadow: 0 -1px 10px #ccc;
    z-index:2;
    &-tip{
      font-size:12px;
      font-family:PingFangSC-Regular;
      font-weight:400;
      color:rgba(192,192,192,1);
      position: absolute;
      bottom:1px;
      right:130px;
    }
    &-sub {
      width: 115px;
      height: 45px;
      background:$theme-five-color;
      text-align: center;
      line-height: 45px;
      font-family: PingFangSC-Regular;
      font-size: 16px;
      font-weight: 500;
      letter-spacing: 0px;
      color: #ffffff;
    }
    &-total2 {
      font-family: PingFangSC-Regular;
      font-size:18px;
      letter-spacing: 0px;
      font-weight:600;
      color: $theme-two-color;
      margin-right: 14px;
    }
    &-total {
      font-family: PingFangSC-Regular;
      font-size: 12px;
      letter-spacing: 0px;
      color: $theme-one-color;
    }
  }
  .countpage {
    width: 100%;
    min-height: 200px;
    background: white;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    &-title {
      font-size: 16px;
      line-height: 22px;
      color: rgba(31, 31, 31, 1);
      text-align: center;
      margin-top: 20px;
    }
    &-foot {
      width: 100%;
      height: 50px;
      background: #b52902;
      text-align: center;
      line-height: 50px;
      font-size: 14px;
      color: rgba(255, 255, 255, 1);
    }
  }
  .discount {
    width: 100%;
    background: white;
    margin-top: 5px;
    min-height: 100px;
    &-head {
      height: 50px;
      width: 100%;
      display: flex;
      align-items: center;
      padding: 0 15px;
      box-sizing: border-box;
      color: $text-color;
      font-size: 14px;
      font-weight: 400;
    }
    &-items {
      width: 345px;
      height: 88px;
      margin: 0 auto;
      border-radius: 4px;
      border: 1px solid #ffeae4;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      margin-top: 15px;
      &-left {
        height: 68px;
        width: 220px;
        padding-left: 20px;
        box-sizing: border-box;
        &-t1 {
          font-size: 12px;
          font-weight: 400;
          color: rgba(255, 55, 0, 1);
          line-height: 20px;
          margin-top: 15px;
        }
        &-t2 {
          font-size: 10px;
          font-weight: 400;
          color: rgba(135, 135, 135, 1);
          line-height: 20px;
        }
      }
      &-right {
        height: 68px;
        width: 120px;
        border-left: 1px dotted #ffeae4;
        &-box {
          width: 75px;
          height: 38px;
          background: rgba(255, 234, 228, 1);
          border-radius: 19px;
          text-align: center;
          line-height: 38px;
          font-size: 14px;
          color: rgba(255, 55, 0, 1);
          margin: 0 auto;
          margin-top: 15px;
        }
        .yilinqu {
          color: rgba(255, 55, 0, 0.3);
        }
      }
    }
  }
  .GoNewadd {
    width: 100%;
    height: 75px;
    background: white;
    padding: 0 17px;
    box-sizing: border-box;
    display: flex;
		justify-content: space-between;
		align-items: center;
    color:rgba(153,153,153,1);
    font-size:16px;
		img{
			height: 11px;
		}
  }
  .caidai{
    width: 100%;
    height: 4px;
    background: url('../../../assets/img/society/caidai.png')
  }
  .caidai2{
    width: 100%;
    height: 52px;
    padding: 0 16px;
    box-sizing: border-box;
    font-size:14px;
    font-family:PingFangSC-Medium;
    font-weight:500;
    color:rgba(29,30,31,1); 
    line-height: 52px;
    background: white;
    margin-bottom:1px;    
  }
  .blankBox{
    height: 8px;
  }
  .zhegai {
    width: 100%;
    height: 100%;
    background: rgba(34, 34, 34, 0.4);
    position: fixed;
    top: 0;
    left: 0;
  }
  .passcon {
    height: 200px;
    width: 100%;
    background: white;
    position: fixed;
    z-index: 999;
    top: 100px;
    &-t1 {
      font-size: 14px;
      font-family: PingFang-SC-Medium;
      font-weight: 500;
      color: rgba(53, 53, 53, 1);
      text-align: center;
      margin: 20px 0;
    }
  }
  .cup-img{
    height: 14px;
  }
  .cup-alive{
    min-width:60px;
    height:24px;
    background:linear-gradient(41deg,rgba(215,43,24,1) 0%,rgba(215,24,87,1) 100%);
    border-radius:12px; 
    position: absolute;
    bottom: 14px;
    right:34px;
    text-align: center;
    line-height: 24px;
    font-size:12px;
    font-family:PingFangSC-Medium;
    font-weight:500;
    color:rgba(255,255,255,1);     
  }
  .cup-num{
    min-width:60px;
    height:24px;    
    font-size:14px;
    border-radius:12px; 
    position: absolute;
    bottom: 14px;
    right:34px;
    text-align: center;
    line-height: 24px;     
    font-family:PingFangSC-Medium;
    font-weight:500;
    color:rgba(196,13,0,1);
      
  }
}
</style>

