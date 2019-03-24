<template>
  <div class="uploadPage">
    <form enctype='multipart/form-data' id='aa' name='aaa' method='post' action='../../../../php/upload/txtUpload.php'>
      <input name='file' style="cursor:pointer;" type='file' />
      <input type="submit" style="cursor:pointer;" value="上传修改数据"/>
    </form>
  </div>
</template>
<script>
export default {
  
}
</script>
<style lang="scss">
.uploadPage{

}
</style>


