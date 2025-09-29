<template>
  <form @submit="formSubmit">
    <div>
      <CardTitle title="Integration" icon="fa-solid fa-sliders"></CardTitle>
    </div>
    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-is_application_link">{{ $t('setting_integration_page.lbl_application') }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="is_application_link" :checked="is_application_link == 1 ? true : false" name="is_application_link" id="category-is_application_link" type="checkbox" v-model="is_application_link" />
        </div>
      </div>
    </div>
    <div v-if="is_application_link == 1" class="bg-body mt-3 px-5 py-4 mb-5">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12 mb-0" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_playstore')" placeholder="" v-model="customer_app_play_store" :error-message="errors['customer_app_play_store']" :error-messages="errorMessages['customer_app_play_store']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12 mb-0" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_appstore')" placeholder="" v-model="customer_app_app_store" :error-message="errors['customer_app_app_store']" :error-messages="errorMessages['customer_app_app_store']"></InputField>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-isForceUpdateforAndroid">{{ $t('setting_integration_page.lbl_isforceupdate') }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="isForceUpdateforAndroid" :checked="isForceUpdateforAndroid == 1 ? true : false" name="isForceUpdateforAndroid" id="category-isForceUpdateforAndroid" type="checkbox" v-model="isForceUpdateforAndroid" />
        </div>
      </div>
    </div>
    <div v-if="isForceUpdateforAndroid == 1" class="bg-body mt-3 px-5 py-4 mb-5">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12 mb-0" type="text" :is-required="true" :label="$t('setting_integration_page.adndroid_minimum_version_code')" placeholder="" v-model="android_minimum_force_update_code" :error-message="errors['android_minimum_force_update_code']" :error-messages="errorMessages['android_minimum_force_update_code']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12 mb-0" type="text" :is-required="true" :label="$t('setting_integration_page.adndroid_latest_version_code')" placeholder="" v-model="android_latest_version_update_code" :error-message="errors['android_latest_version_update_code']" :error-messages="errorMessages['android_latest_version_update_code']"></InputField>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-isForceUpdateforIos">{{ $t('setting_integration_page.lbl_isforceupdate_employee') }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="isForceUpdateforIos" :checked="isForceUpdateforIos == 1 ? true : false" name="isForceUpdateforIos" id="category-isForceUpdateforIos" type="checkbox" v-model="isForceUpdateforIos" />
        </div>
      </div>
    </div>
    <div v-if="isForceUpdateforIos == 1" class="bg-body mt-3 px-5 py-4 mb-5">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12 mb-0" type="text" :is-required="true" :label="$t('setting_integration_page.ios_minimum_version_code')" placeholder="" v-model="iso_minimum_force_update_code" :error-message="errors['iso_minimum_force_update_code']" :error-messages="errorMessages['iso_minimum_force_update_code']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12 mb-0" type="text" :is-required="true" :label="$t('setting_integration_page.ios_latest_version_code')" placeholder="" v-model="iso_latest_version_update_code" :error-message="errors['iso_latest_version_update_code']" :error-messages="errorMessages['iso_latest_version_update_code']"></InputField>
        </div>
      </div>
    </div>
    <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
  </form>
</template>
<script setup>
import { ref, watch } from 'vue'
import CardTitle from '@/Setting/Components/CardTitle.vue'
import * as yup from 'yup'
import { useField, useForm } from 'vee-validate'
import { STORE_URL, GET_URL } from '@/vue/constants/setting'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import { onMounted } from 'vue'
import { createRequest } from '@/helpers/utilities'
import SubmitButton from './Forms/SubmitButton.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'
const { storeRequest } = useRequest()
const IS_SUBMITED = ref(false)
//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
    
      is_application_link: data.is_application_link  || '',
      customer_app_play_store: data.customer_app_play_store  || '',
      customer_app_app_store: data.customer_app_app_store  || '',
      isForceUpdateforAndroid: data.isForceUpdateforAndroid  || 0,
      android_minimum_force_update_code: data.android_minimum_force_update_code  || '',
      android_latest_version_update_code: data.android_latest_version_update_code  || '',
      isForceUpdateforIos: data.isForceUpdateforIos  || 0,
      ios_minimum_version_code: data.ios_minimum_version_code  || '',
      iso_minimum_force_update_code: data.iso_minimum_force_update_code  || '',
  
    }
  })
}
//validation
const validationSchema = yup.object({

  customer_app_play_store: yup.string().test('customer_app_play_store',"Must be a valid Customer Playstore App Key", function(value) {
    if(this.parent.is_application_link == '1' && !value) {
      return false;
    }
    return true
  }),
  customer_app_app_store: yup.string().test('customer_app_app_store',"Must be a valid Customer App Key", function(value) {
    if(this.parent.is_application_link == '1' && !value) {
      return false;
    }
    return true
  }),


  android_minimum_force_update_code: yup.string().test('android_minimum_force_update_code', "Minimum version code for Android is Required", function(value) {
    if(this.parent.isForceUpdateforAndroid == '1' && !value) {
      return false;
    }
    return true
  }),
  android_latest_version_update_code: yup.string().test('android_latest_version_update_code', "Latest version code for Android is Required", function(value) {
    if(this.parent.isForceUpdateforAndroid == '1' && !value) {
      return false;
    }
    return true
  }),

  iso_minimum_force_update_code: yup.string().test('iso_minimum_force_update_code', "Minimum version code for Ios is Required", function(value) {
    if(this.parent.isForceUpdateforIos == '1' && !value) {
      return false;
    }
    return true
  }),
  iso_latest_version_update_code: yup.string().test('iso_latest_version_update_code', "Latest version code for Ios is Required", function(value) {
    if(this.parent.isForceUpdateforIos == '1' && !value) {
      return false;
    }
    return true
  }),


})
const { handleSubmit, errors, resetForm, validate } = useForm({validationSchema})
const errorMessages = ref({})

const { value: is_application_link } = useField('is_application_link')
const { value: customer_app_play_store } = useField('customer_app_play_store')
const { value: customer_app_app_store } = useField('customer_app_app_store')
const { value: isForceUpdateforAndroid } = useField('isForceUpdateforAndroid')
const { value: android_minimum_force_update_code } = useField('android_minimum_force_update_code')
const { value: android_latest_version_update_code } = useField('android_latest_version_update_code')
const { value: isForceUpdateforIos } = useField('isForceUpdateforIos')
const { value: iso_minimum_force_update_code } = useField('iso_minimum_force_update_code')
const { value: iso_latest_version_update_code } = useField('iso_latest_version_update_code')


watch(() => isForceUpdateforAndroid.value, (value) => {
  if(value == '0') {
    android_minimum_force_update_code.value = ''
    android_latest_version_update_code.value = ''
  }
}, {deep: true})
watch(() => isForceUpdateforIos.value, (value) => {
  if(value == '0') {
    iso_minimum_force_update_code.value = ''
    iso_latest_version_update_code.value = ''
  }
}, {deep: true})

// message
const display_submit_message = (res) => {
  IS_SUBMITED.value = false
  if (res.status) {
    window.successSnackbar(res.message)
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.errors
  }
}

//fetch data
const data = [

  'is_application_link', 
  'isForceUpdateforAndroid',
  'isForceUpdateforIos',

]

const customer_app = [
  'customer_app_play_store',
  'customer_app_app_store',

]

const versions_key = [
  'android_minimum_force_update_code',
  'android_latest_version_update_code',
  'iso_minimum_force_update_code',
  'iso_latest_version_update_code',
]
onMounted(() => {

  const customData = [
    ...data,
    ...customer_app,
    ...versions_key,
  ].join(",")

  createRequest(GET_URL(customData)).then((response) => {
    setFormData(response)
  })
})

//Form Submit
const formSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  const newValues = {}
  Object.keys(values).forEach((key) => {
    if(values[key] !== '') {
      newValues[key] = values[key] || ''
    }
  })
  storeRequest({
    url: STORE_URL, 
    body: newValues
  }).then((res) => display_submit_message(res))
})

defineProps({
  label: { type: String, default: '' },
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: '' },
  errorMessage: { type: String, default: '' },
  errorMessages: { type: Array, default: () => [] }
})
</script>
