<template>
  <div class="col-md-4 col-lg-3">
    <div class="card">
      <div class="card-body">
        <div class="list-group list-group-flush customizer-panel">
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.home'}" class="btn btn-border"><i class="fas fa-cube"></i>General</router-link></div>
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.misc'}" class="btn btn-border"><i class="fa-solid fa-screwdriver-wrench "></i>Misc Settings</router-link></div>
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.custom-code'}" class="btn btn-border"><i class="fa-solid fa-file-code"></i>Custom Code</router-link></div>
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.customization'}" class="btn btn-border"><i class="fa-solid fa-swatchbook"></i>Customization</router-link></div>
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.mail'}" class="btn btn-border"><i class="fas fa-envelope"></i>Mail Setting</router-link></div>
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.notificationsetting'}" class="btn btn-border"><i class="fa-solid fa-bullhorn"></i>Notification Setting</router-link></div>
          <div v-if="role() == 'admin'"  class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.integration'}" class="btn btn-border"><i class="fa-solid fa-sliders"></i>Integration</router-link></div>
          <div v-if="role() == 'admin'" class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.other-settings'}" class="btn btn-border"><i class="fa-solid fa-sliders"></i>App Configuration Settings</router-link></div>
          <!-- <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.custom-fields'}" class="btn btn-border"><i class="fa-solid fa-bars"></i>Custom Fields</router-link></div> -->
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.currency-settings'}" class="btn btn-border"><i class="fa fa-dollar fa-lg mr-2"></i>Currency Setting</router-link></div>
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.payment-method'}" class="btn btn-border"><i class="fa-solid fa-coins"></i>Payment Method</router-link></div>
          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.language-settings'}" class="btn btn-border"><i class="fa fa-language" aria-hidden="true"></i>Language Settings</router-link></div>

          <div class="mb-3" @click="toggle()"><router-link :to="{name: 'Settings.push-notification'}" class="btn btn-border"><i class="fa-solid fa-bell" aria-hidden="true"></i>Push Notification</router-link></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
const toggle = () =>{
  const formOffcanvas = document.getElementById('offcanvas')
  formOffcanvas.classList.add("show")
}
const hasPermissions = (name) => {
  return window.auth_permissions.includes(name)
}
const role = () => {
  return window.auth_role[0]
}


</script>
<style scoped>
.btn-border {
  text-align: left;
  display: flex;
  align-items: center;
  gap: .75rem;
}
</style>
