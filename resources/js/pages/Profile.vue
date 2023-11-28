<script setup>
import { ref } from "vue";
const result = ref(false);
const props = defineProps([
    'user'
])

import PhotoComponent from '../components/PhotoComponent.vue'

const userUpdate = (evt) => {
  evt.preventDefault();
  if (
    props.user.name === "" ||
    props.user.email === ""
  ) {
    alert("Please fill all fields")
  } else {
    axios
      .post("user-update", props.user)
      .then((resp) => {
        alert(resp.data.message)
      })
      .catch((err) => {
        alert(err);
      });
  }
};

const submitFile = (file) => {
    result.value = false
    let formData = new FormData()
    formData.append('file', file)
    formData.append('id', props.user.id)
    axios.post('profile-upload', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((res) => {
        props.user.photo = res.data.path
        result.value = true
        alert(res.data.message)
    }).catch((err) => {
        result.value = false
        alert(err.response.data.message)
    })
}
//AULA 09 - 7:20
</script>
<template>
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-profile-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
                  
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Profile</h1>
              </div>
              <form @submit.prevent="userUpdate" class="user" method="post">
                <div class="form-group">
                  <input
                    type="text"
                    v-model="props.user.name"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="email"
                    v-model="props.user.email"
                    class="form-control form-control-user"
                    id="exampleInputEmail"
                    placeholder="Email Address"
                  />
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  Update
                </button>
              
              </form>
              <hr />
              <div class="text-center">
                <router-link class="small" to="reset-password-form-sent"
                  >Change Password</router-link
                >
              </div>
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card pb-5">
                    <PhotoComponent class="m-auto" @isEmit="submitFile($event)" :result="result"/>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
</template>