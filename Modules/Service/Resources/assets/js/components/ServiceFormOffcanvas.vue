<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">

        <div class="form-group">
          <div class="text-center">
            <img :src="ImageViewer || props.defaultImage" alt="feature-image" class="img-fluid mb-2 avatar avatar-140 avatar-rounded" />
          </div>
          <label class="form-label" for="feature_image">{{$t('category.lbl_feature_image')}} <span v-if="currentId ==0" class="text-danger">*</span> </label>
          <input type="file" class="form-control" id="feature_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
          <span v-if="errorMessages['feature_image']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['feature_image']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.feature_image }}</span>
        </div>

        <InputField class="col-md-12" type="text" :is-required="true" :label="$t('service.lbl_service_name')" placeholder="" v-model="name" :error-message="errors['name']" :error-messages="errorMessages['name']"></InputField>

        <div class="form-group">
          <label class="form-label" for="type">{{ $t('category.lbl_type') }}  <span class="text-danger">*</span> </label>
          <Multiselect v-model="type" :value="type" @click="selectType"  v-bind="singleSelectOption" id="type" :options="type_arr"></Multiselect>
          <span v-if="errorMessages['type']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['type']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.type }}</span>
        </div>
   
        <div class="form-group">
          <label class="form-label" for="category_id">{{ $t('service.lbl_category') }} <span class="text-danger">*</span> </label>
          <Multiselect v-bind="singleSelectOption" v-model="category_id" :value="category_id" id="category_id" :options="categories"></Multiselect>
          <span v-if="errorMessages['category_id']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['category_id']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.category_id }}</span>
        </div>

        <!-- <div class="form-group" v-if="subCategories.options.length > 0">
          <label class="form-label" for="sub_category_id">{{ $t('service.lbl_sub_category') }} </label>
          <Multiselect v-model="sub_category_id" :value="sub_category_id" v-bind="subCategories" id="sub_category_id"></Multiselect>
          <span v-if="errorMessages['sub_category_id']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['sub_category_id']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.sub_category_id }}</span>
        </div> -->


        <div v-for="field in customefield" :key="field.id">
          <FormElement v-model="custom_fields_data" :name="field.name" :label="field.label" :type="field.type" :required="field.required" :options="field.value" :field_id="field.id"></FormElement>
        </div>

        <div class="form-group col-md-12">
              <label class="form-label" for="description">{{$t('service.lbl_description')}}</label>
              <textarea class="form-control" v-model="description" id="description"></textarea>
              <span v-if="errorMessages['description']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['description']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.description }}</span>
            </div>

        <div class="form-group mb-0">
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
import { EDIT_URL, STORE_URL, UPDATE_URL, CATEGORY_LIST,SYSTERM_SERVICE_LIST } from '../constant/service'
import { useField, useForm } from 'vee-validate'
import InputField from '@/vue/components/form-elements/InputField.vue'

import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
import * as yup from 'yup'
import { buildMultiSelectObject } from '@/helpers/utilities'
import { readFile } from '@/helpers/utilities'
import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
import FormElement from '@/helpers/custom-field/FormElement.vue'

// props
const props = defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
  defaultImage: { type: String, default: 'https://dummyimage.com/600x300/cfcfcf/000000.png' },
  customefield: { type: Array, default: () => [] }
})

const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

const currentId = useModuleId(() => {
  if (currentId.value > 0) {

    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => {
      if (res.status) {
        setFormData(res.data)
        getCategories(res.data.type)
      
      }
    })
  } else {
    setFormData(defaultData())
  }
})


const ImageViewer = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
  feature_image.value = file
}

const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true
})
const type_arr = ref([])
const categories = ref([])

const getType = () => {
  listingRequest({ url: SYSTERM_SERVICE_LIST })
    .then((res) => {
      type_arr.value = buildMultiSelectObject(res, { value: 'id', label: 'name' });
    });
};

const selectType=()=>{
  category_id.value=''
  getCategories(type.value)
  
}

const getCategories = (value) => {

 listingRequest({ url: CATEGORY_LIST, data: { type: value } }).then((res) => (categories.value= buildMultiSelectObject(res, { value: 'id', label: 'name' })))
}



/*
 * Form Data & Validation & Handeling
 */
// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    description: '',
    status: 1,
    type:'',
    category_id: '',
    sub_category_id: '',
    feature_image: null,
    custom_fields_data: {}
  }
}

//  Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.feature_image
  resetForm({
    values: {
      name: data.name,
      description: data.description,
      status: data.status,
      type:data.type,
      category_id: data.category_id,
      sub_category_id: data.sub_category_id,
      feature_image:  data.feature_image,
      custom_fields_data: data.custom_field_data
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

  feature_image: yup
  .string()
  .test('feature_image', 'Service image is required', function (value) {
    if (currentId === 0 && !value) {
      return false;
    }
    return true;
  })
  .label('Service Image'),
  name: yup.string().required('Name is a required field'),

  category_id: yup.string().required('Category is a required field').matches(/^\d+$/, 'Only numbers are allowed'),
  type: yup.string().required('Type is a required field'),

   description:yup.string().nullable().test('no-script-tags', 'The Description field cannot contain script tags.', function(value) {
    const scriptTagRegex = /<script\b[^>]*>(.*?)/is;
    return !scriptTagRegex.test(value);
  }),
})


const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: name } = useField('name')
const { value: description } = useField('description')
const { value: status } = useField('status')
const { value: category_id } = useField('category_id')
const { value: type } = useField('type')
const { value: sub_category_id } = useField('sub_category_id')
const { value: feature_image } = useField('feature_image')
const { value: custom_fields_data } = useField('custom_fields_data')

const errorMessages = ref({})

onMounted(() => {
  getType()
  getCategories()
  setFormData(defaultData())
})


const formSubmit = handleSubmit((values) => {
  values.custom_fields_data = JSON.stringify(values.custom_fields_data)
  if (currentId.value > 0) {
    updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  } else {
    storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  }
})

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
</script>
