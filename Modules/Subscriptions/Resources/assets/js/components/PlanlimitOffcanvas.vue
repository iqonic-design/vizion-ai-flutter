<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="name">{{ $t('plan_limitation.lbl_name') }}  <span class="text-danger">*</span></label>
              <input type="text" class="form-control" v-model="name" :placeholder="$t('placeholder.limit_name')"  id="name" />
              <span v-if="errorMessages['name']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['name']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.name }}</span>
            </div>

            <div class="form-group">
              <label class="form-label" for="limit_type">{{ $t('plan_limitation.lbl_limit_type') }}  <span class="text-danger">*</span> </label>
              <Multiselect v-model="limit_type" :placeholder="$t('placeholder.limit_type')" :value="limit_type"  v-bind="limit_type_data" id="limit_type" ></Multiselect>
              <span v-if="errorMessages['limit_type']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['limit_type']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.limit_type }}</span>
            </div>

            <div class="form-group" v-if="limit_type=='system_service'">
              <label class="form-label" for="type">{{ $t('category.lbl_type') }}  <span class="text-danger">*</span> </label>
              <Multiselect v-model="type" :placeholder="$t('placeholder.service_type')" :value="type"  v-bind="singleSelectOption" id="type" :options="type_arr"></Multiselect>
              <span v-if="errorMessages['type']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['type']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.type }}</span>
            </div>

            <div class="form-group" v-if="limit_type=='category'">
              <label class="form-label" for="type">{{ $t('category.lbl_type') }}  <span class="text-danger">*</span> </label>
              <Multiselect v-model="type" :placeholder="$t('placeholder.category_name')" :value="type"  v-bind="singleSelectOption" id="type" :options="category_list"></Multiselect>
              <span v-if="errorMessages['type']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['type']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.type }}</span>
            </div>


            <div class="form-group">
              <label class="form-label" for="limit">{{ $t('plan_limitation.lbl_set_limit') }} <span class="text-danger">*</span></label>
              <input type="number" class="form-control" v-model="limit"   :placeholder="$t('placeholder.limit')" id="limit" />
              <span v-if="errorMessages['limit']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['limit']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.limit }}</span>
            </div>
            <div class="form-group">
              <div class="d-flex justify-content-between align-items-center">
                <label class="form-label" for="category-status">{{ $t('plan_limitation.lbl_status') }}</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" :value="status" :checked="status" name="status" id="category-status" type="checkbox" v-model="status" />
                </div>
              </div>
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
import { EDIT_URL, STORE_URL, UPDATE_URL,SYSTERM_SERVICE_LIST ,CATEGORY_LIST} from '../constant/planlimit'
import { useField, useForm } from 'vee-validate'
import { buildMultiSelectObject } from '@/helpers/utilities'
import { useModuleId, useRequest,useOnOffcanvasHide} from '@/helpers/hooks/useCrudOpration'
import * as yup from 'yup'

import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'

// props
defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' }
})

const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

onMounted(() => {

  setFormData(defaultData())
  getType()
  getCategory()
})

// Edit Form Or Create Form
const currentId = useModuleId(() => {
  if (currentId.value > 0) {
    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => res.status && setFormData(res.data))
  } else {
    setFormData(defaultData())
  }
})

const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true
})

const type_arr = ref([])

const getType = () => {
  listingRequest({ url: SYSTERM_SERVICE_LIST })
    .then((res) => {
      type_arr.value = buildMultiSelectObject(res, { value: 'id', label: 'name' });
    });
};


const category_list = ref([])

const getCategory = () => {
  listingRequest({ url: CATEGORY_LIST })
    .then((res) => {
  
      category_list.value = buildMultiSelectObject(res, { value: 'id', label: 'name' });
    });
};


const limit_type_data = ref({
  searchable: true,
  options: [

    { label: 'System Service', value: 'system_service' },
    { label: 'Category', value: 'category' }
  ],
  createOption: true,
  closeOnSelect: true
})




/*
 * Form Data & Validation & Handeling
 */
// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    limit: '',
    type: '',
    limit_type:'',
    status: 1
  }
}

//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
      name: data.name,
      limit: data.limit,
      type: data.type,
      limit_type:data.limit_type,
      status: data.status,
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

const numberRegex = /^\d+$/;
// Validations
const validationSchema = yup.object({
  name: yup.string()
    .required('Name is a required field')
    .test('is-string', 'Only strings are allowed', (value) => !numberRegex.test(value)),

    type: yup.string()
    .required('Type is a required field'),

    limit_type: yup.string()
    .required('Limit type is a required field'),

   
  limit: yup.string()
    .required('Set Limit is a required field')
    .matches(/^\d+$/, 'Only numbers are allowed')
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: name } = useField('name')
const { value: limit } = useField('limit')
const { value: limit_type } = useField('limit_type')
const { value: type } = useField('type')
const { value: status } = useField('status')
const errorMessages = ref({})



// Form Submit
const formSubmit = handleSubmit((values) => {
  if (currentId.value > 0) {
    updateRequest({ url: UPDATE_URL, id: currentId.value, body: values }).then((res) => reset_datatable_close_offcanvas(res))
  } else {
    storeRequest({ url: STORE_URL, body: values }).then((res) => reset_datatable_close_offcanvas(res))
  }
})

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))

</script>
