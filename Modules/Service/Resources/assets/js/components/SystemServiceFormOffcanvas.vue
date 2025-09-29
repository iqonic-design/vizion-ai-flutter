<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">
        <div class="form-group">
          <div class="text-center">
            <img :src="ImageViewer || defaultImage" alt="feature-image" class="img-fluid mb-2 avatar avatar-140 avatar-rounded" />
          </div>

          <div class="form-group">
            <div class="input-group">
              <input type="file" class="form-control" id="feature_image" ref="refInput" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" style="opacity: 0; position: absolute; z-index: -1" />
              <label for="feature_image" style="cursor: pointer; border: 1px solid #5f5d5d61; padding: 5px 10px"> Choose File </label>
              <input type="text" class="form-control" :value="fileName" readonly />
            </div>
          </div>

          <span v-if="errorMessages['feature_image']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['feature_image']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.feature_image }}</span>
        </div>

        <InputField class="col-md-12" type="text" :is-required="true" :label="$t('service.lbl_name')" placeholder="" v-model="name" :error-message="errors['name']" :error-messages="errorMessages['name']"></InputField>

        <div v-for="field in customefield" :key="field.id">
          <FormElement v-model="custom_fields_data" :name="field.name" :label="field.label" :type="field.type" :required="field.required" :options="field.value" :field_id="field.id"></FormElement>
        </div>

        <div class="form-group col-md-12">
          <label class="form-label" for="description">{{ $t('service.lbl_description') }}</label>
          <textarea class="form-control" v-model="description" id="description"></textarea>
          <span v-if="errorMessages['description']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['description']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.description }}</span>
        </div>

        <div class="form-group">
          <div class="d-flex justify-content-between align-items-center">
            <label class="form-label" for="category-status">{{ $t('service.lbl_status') }}</label>
            <div class="form-check form-switch">
              <input class="form-check-input" :value="status" :checked="status" name="status" id="category-status" type="checkbox" v-model="status" />
            </div>
          </div>
        </div>
      </div>
      <FormFooter></FormFooter>
    </div>
  </form>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { SYSTEM_SERVICE_EDIT_URL, STORE_URL, SYSTEM_SERVICE_UPDATE_URL } from '../constant/service'
import { useField, useForm } from 'vee-validate'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
import * as yup from 'yup'
import { readFile } from '@/helpers/utilities'
import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
import FormElement from '@/helpers/custom-field/FormElement.vue'

// Props
defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
  defaultImage: { type: String, default: 'https://dummyimage.com/600x300/cfcfcf/000000.png' },
  customefield: { type: Array, default: () => [] }
})

const { getRequest, storeRequest, updateRequest } = useRequest()

// Edit Form Or Create Form
const currentId = useModuleId(() => {
  if (currentId.value > 0) {
    getRequest({ url: SYSTEM_SERVICE_EDIT_URL, id: currentId.value }).then((res) => {
      if (res.status) {
        setFormData(res.data)
      }
    })
  } else {
    setFormData(defaultData())
  }
})

// File Upload Function
const ImageViewer = ref(null)
const fileName = ref('')
const fileUpload = async (e) => {
  let file = e.target.files[0]
  if (file) {
    await readFile(file, (fileB64) => {
      ImageViewer.value = fileB64
      fileName.value = file.name
    })
    feature_image.value = file
  }
}

/*
 * Form Data & Validation & Handling
 */
const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    description: '',
    status: 0,
    feature_image: null,
    feature_image_name: ''
  }
}

// Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.feature_image
  fileName.value = data.feature_image_name || ''
  resetForm({
    values: {
      name: data.name,
      description: data.description,
      status: data.status
    }
  })
}

// Reload Datatable, SnackBar Message, Alert, Offcanvas Close
const reset_datatable_close_offcanvas = (res) => {
  if (res.status) {
    window.successSnackbar(res.message)
    renderedDataTable.ajax.reload(null, false)
    bootstrap.Offcanvas.getInstance('#form-offcanvas').hide()
    setFormData(defaultData())
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.all_message
  }
}

const numberRegex = /^\d+$/

// Validations
const validationSchema = yup.object({
  name: yup.string().required('Name is a required field'),
  description: yup.string().test('no-script-tags', 'The Description field cannot contain script tags.', function (value) {
    const scriptTagRegex = /<script\b[^>]*>(.*?)/is
    return !scriptTagRegex.test(value)
  })
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})

const { value: name } = useField('name')
const { value: description } = useField('description')
const { value: custom_fields_data } = useField('custom_fields_data')
const { value: feature_image } = useField('feature_image')
const { value: status } = useField('status')

const errorMessages = ref({})

onMounted(() => {
  setFormData(defaultData())
})

// Form Submit
const formSubmit = handleSubmit((values) => {
  values.custom_fields_data = JSON.stringify(values.custom_fields_data)
  if (currentId.value > 0) {
    updateRequest({ url: SYSTEM_SERVICE_UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  } else {
    storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  }
})

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
</script>

