<script setup>
import { ref } from "vue";
import { watchEffect } from "@vue/runtime-core";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

const emit = defineEmits(["isEmit"]);
const props = defineProps(["result"]);

const img = ref("");
const image = ref("");
const show = ref(false);

const change = ({ coordinates, canvas }) => {
  image.value = canvas.toDataURL();
  show.value = true;
};

const uploadFile = (e) => {
  var reader,
    files = e.target.files;
  reader = new FileReader();
  reader.onload = (e) => {
    img.value = e.target.result;
  };
  reader.readAsDataURL(files[0]);
};

const submitFile = () => {
  if (image.value === "") {
    alert("Please select image");
    return;
  }

  var arr = image.value.split(","),
    mime = arr[0].match(/:(.*?);/)[1],
    bstr = atob(arr[1]),
    n = bstr.length,
    u8arr = new Uint8Array(n);

  while (n--) {
    u8arr[n] = bstr.charCodeAt(n);
  }

  var file = new File([u8arr], "filename.png", { type: mime });
  emit("isEmit", file);
};

watchEffect(() => {
  if (props.result) {
    image.value = "";
    img.value = "";
  }
});
</script>

<template>
  <div style="width: 350px; margin-top: 100px ">
    <button style="margin:10px 0px 5px 0px" type="button" class="btn btn-primary" @click="submitFile">
      Save
    </button>
    <div style="width: 400px;margin:0px 0px 10px 0px;">
      <img :src="image" style="width: 200px; margin-bottom: 10px" />
      <cropper
        class="cropper"
        :src="img"
        :stencil-props="{ aspectRatio: 10 / 10 }"
        @change="change"
      ></cropper>
      <div class="input-group">
        <input
          type="file"
          class="form-control"
          placeholder="Upload Image"
          @change="uploadFile"
          ref="file"
        />
      </div>
    </div>
  </div>
</template>