<template>
    <form @submit="formSubmit">
        <div>
            <CardTitle title="Push Notification" icon="fa-solid fa-bell"></CardTitle>
        </div>

        <label class="form-label" for="title">{{ $t('setting_language_page.lbl_title') }} </label><span class="text-danger">*</span>
        <input type="text" class="form-control mb-3" v-model="title" id="title"
            name="title" :errorMessage="errors.title"
            :errorMessages="errorMessages.title" />
        <span class="text-danger">{{ errors.title }}</span>

        <TextArea :is-required="true" :label="$t('setting_language_page.lbl_description')" placeholder="description" v-model="description" :errorMessage="errors.description"> </TextArea>

        <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
    </form>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import CardTitle from '@/Setting/Components/CardTitle.vue'
import TextArea from '@/Setting/Components/TextArea.vue'
import * as yup from 'yup'
import { useField, useForm } from 'vee-validate'
import { PUSH_NOTIFICATION } from '@/vue/constants/setting'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import { createRequest } from '@/helpers/utilities'
import SubmitButton from './Forms/SubmitButton.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'
const { storeRequest } = useRequest()
const IS_SUBMITED = ref(false)

const setFormData = (data) => {
  resetForm({
    values: {
        
        title: data.title  || '',
        description: data.description  || '',
  
    }
  })
}
//validation
const validationSchema = yup.object({
    title: yup.string().required('Title is a required field'),
    description: yup.string().required('Description is a required field')
})


const { handleSubmit, errors, resetForm } = useForm({validationSchema})
const errorMessages = ref({})

const { value: title } = useField('title')
const { value: description } = useField('description')


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


onMounted(() => {

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
    url: PUSH_NOTIFICATION, 
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