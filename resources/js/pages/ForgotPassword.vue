<script setup>
import { ref } from "vue";
const email = ref("t@email.com");
const loadIng = ref(false);
const send = ref(false);
const errorMsg = ref("");

const resetPassword = (evt) => {
  evt.preventDefault();
  if (email.value === "") {
    alert("Please fill all fields");
  } else {
    loadIng.value = true;
    axios
      .post("reset-password", {
        email: email.value,
      })
      .then((res) => {
        console.log("OLA", res);
        loadIng.value = false;
        send.value = true;
        alert(res.data.message);
      })
      .catch((err) => {
        loadIng.value = false;
        send.value = false;
        if (err.response.status === 400) {
           errorMsg.value = err.response.data.message;
        }
      });
  }
};
</script>

<template>
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div v-if="!send" class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <div
                      v-if="errorMsg"
                      class="alert alert-danger"
                      role="alert"
                    >
                      <i style="cursor:pointer;" @click="errorMsg = ''" class="fa-solid fa-x mr-3"></i>
                      {{ errorMsg }}
                    </div>
                    <h1 class="h4 text-success mb-2">Send Link</h1>
                    <p class="mb-4 text-success">
                      Send you a link to reset your password!
                    </p>
                  </div>
                  <form class="user">
                    <div v-if="!loadIng" class="form-group">
                      <input
                        type="email"
                        v-model="email"
                        class="form-control form-control-user"
                        id="exampleInputEmail"
                        aria-describedby="emailHelp"
                        placeholder="Enter Email Address..."
                      />
                    </div>
                    <a
                      href="#"
                      v-if="!loadIng"
                      @click="resetPassword"
                      class="btn btn-primary btn-user btn-block"
                    >
                      Reset Password
                    </a>
                    <a
                      v-if="loadIng"
                      class="btn btn-primary btn-user btn-block"
                    >
                      Waiting...
                    </a>
                  </form>
                  <hr />
                  <div class="text-center">
                    <router-link class="small" to="/register"
                      >Create an Account!</router-link
                    >
                  </div>
                  <div class="text-center">
                    <router-link class="small" to="login"
                      >Already have an account? Login!</router-link
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>