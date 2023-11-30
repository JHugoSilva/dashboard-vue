<script setup>
import { ref } from "vue";
const result = ref(false);
import { toast } from "vue3-toastify";
const props = defineProps(["user"]);

import PhotoComponent from "../components/PhotoComponent.vue";

const notify = (message, id) => {
  toast.success(message, {
    toastId: id,
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
  });
};

const notifyErro = (message, id) => {
  toast.error(message, {
    toastId: id,
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
  });
};

const userUpdate = (evt) => {
  evt.preventDefault();
  if (props.user.name === "" || props.user.email === "") {
    notifyErro("Please fill all fields", props.user.id);
  } else {
    axios
      .post("user-update", props.user)
      .then((resp) => {
        notify(resp.data.message, props.user.id);
      })
      .catch((err) => {
        notifyErro(err);
      });
  }
};

const submitFile = (file) => {
  result.value = false;
  let formData = new FormData();
  formData.append("file", file);
  formData.append("id", props.user.id);
  axios
    .post("profile-upload", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((res) => {
      props.user.photo = res.data.path;
      result.value = true;
      notify(res.data.message);
      window.location.reload();
    })
    .catch((err) => {
      result.value = false;
      notifyErro(err.response.data.message);
    });
};

const deletePhoto = (id) => {
  axios
    .post(`delete-photo/${id}`)
    .then((res) => {
      notify(res.data.message);
      window.location.reload();
    })
    .catch((err) => {
      notifyErro(err.message);
    });
};

const selectPhoto = (id) => {
  axios
    .post(`select-photo/${id}`)
    .then((res) => {
      notify(res.data.message);
      window.location.reload();
    })
    .catch((err) => {
      notifyErro(err.message);
    });
};
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
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <input
                        type="number"
                        v-model="props.user.mobile"
                        class="form-control form-control-user"
                        id="exampleFirstName"
                        placeholder="Mobile"
                      />
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <input
                        type="text"
                        v-model="props.user.gender"
                        class="form-control form-control-user"
                        id="exampleFirstName"
                        placeholder="Gender"
                      />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    v-model="props.user.father_name"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Father Name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="date"
                    v-model="props.user.date_of_birth"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Birth Date"
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
            <div class="card pb-5 w-100">
              <PhotoComponent
                class="m-auto"
                @isEmit="submitFile($event)"
                :result="result"
              />
            </div>
          </div>

          <div class="col-12">
            <div class="card pb-5">
              <table class="table table-bordered text-center" width="100%">
                <thead>
                  <th>Option</th>
                  <th>Image</th>
                </thead>
                <tfoot></tfoot>
                <tbody>
                  <tr v-for="photo in props.user.photos" :key="photo.id">
                    <td>
                      <button
                        @click="deletePhoto(photo.id)"
                        v-if="photo.name != props.user.photo"
                        class="btn btn-danger btn-circle btn-sm"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                      <button
                        @click="selectPhoto(photo.id)"
                        v-if="photo.name != props.user.photo"
                        class="btn btn-info btn-circle btn-sm"
                      >
                        <i class="fas fa-pencil"></i>
                      </button>
                    </td>
                    <td>
                      <img
                        :src="`../images/users/${photo.name}`"
                        width="50"
                        height="50"
                        class="img-fluid rounded-circle"
                        alt="avatar"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>