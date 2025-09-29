<template>
    <form @submit="formSubmit">
      <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
        <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
        <div class="offcanvas-body">
          <fieldset>
            <legend>{{$t('customtemplate.basic_info')}}</legend>
            <div class="row">
              <div class="col-md-4">
                <div class="text-center">
                  <img :src="ImageViewer || props.defaultImage" alt="feature-image" class="img-fluid mb-2 avatar avatar-140 avatar-rounded" />
                </div>
                <div class="mt-3">
                  <label class="form-label" for="feature_image">{{$t('category.lbl_feature_image')}} <span v-if="currentId ==0" class="text-danger">*</span> </label>
                  <input type="file" class="form-control" id="feature_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
                  <span v-if="errorMessages['feature_image']">
                    <ul class="text-danger">
                      <li v-for="err in errorMessages['feature_image']" :key="err">{{ err }}</li>
                    </ul>
                  </span>
                  <span class="text-danger">{{ errors.feature_image }}</span>
                </div>
              </div>
              <div class="col-md-8">
                <InputField :is-required="true" :label="$t('customtemplate.lbl_template_name')" :placeholder="$t('placeholder.template_name')" v-model="template_name" :error-message="errors.template_name" :error-messages="errorMessages['template_name']"></InputField>

                <label class="form-label" for="description">{{ $t('customtemplate.lbl_template_desc') }} <span class="text-danger">*</span></label>
                <textarea class="form-control" :placeholder="$t('placeholder.template_desc')" v-model="description" id="description"></textarea>
                <span v-if="errorMessages['description']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['description']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <span class="text-danger">{{ errors.description }}</span>
  
              </div>
            </div>
            <div class="row mt-md-4">
              <div class="form-group col-md-6" >
                <label class="form-label" for="category">{{ $t('customtemplate.lbl_template_category') }} <span class="text-danger">*</span></label>
                <Multiselect id="category_id" v-model="category_id"  :value="category_id"
                    :placeholder="$t('placeholder.template_category')" v-bind="singalSelectOption" :options="categories.options" class="form-group">
                </Multiselect>
                <span v-if="errorMessages['category_id']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['category_id']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <span class="text-danger">{{ errors.category_id }}</span>
              </div>

              <div class="form-group col-md-6" >
                <label class="form-label" for="package">{{ $t('customtemplate.lbl_template_package') }} <span class="text-danger">*</span></label>
                <Multiselect id="package_id" v-model="package_id"  :value="package_id"
                    :placeholder="$t('placeholder.template_package')" v-bind="singalSelectOption" :options="packages.options" class="form-group">
                </Multiselect>
                <span v-if="errorMessages['package_id']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['package_id']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <span class="text-danger">{{ errors.package_id }}</span>
              </div>

              <div class="form-group col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="active-status">{{ $t('customtemplate.lbl_active_template') }}</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" :value="status" :checked="status" name="status" id="active-status" type="checkbox" v-model="status" />
                  </div>
                </div>
              </div>
 
              <div class="form-group col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="voice_tone-status">{{ $t('customtemplate.lbl_voice_tone') }}</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input"  :value="inculde_voice_tone" :checked="inculde_voice_tone" name="inculde_voice_tone" id="voice_tone-status" type="checkbox" v-model="inculde_voice_tone" />
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend>{{$t('customtemplate.user_input')}}</legend>
            <div class="row">
              <div v-for="(input, index) in userInputList" :key="index" class="col-md-12">
                <div class="row">
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" :placeholder="$t('placeholder.input_title')" v-model="input.input_title" id="input_title" />
                    <span class="text-danger input_title_err" :id="`input_title_err_${index}`"></span>
                  </div>

                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" :placeholder="$t('placeholder.input_desc')" v-model="input.description" id="description" />
                    <span class="text-danger input_desc_err" :id="`input_desc_err_${index}`"></span>
                  </div>
                  
                  <div class="form-group col-md-4">
                    <Multiselect  id="input_type" v-model="input.input_type" :placeholder="$t('placeholder.select_input')" :value="input.input_type"  @select="SelectInput(index, $event)" v-bind="singalSelectOption" :options="inputData.options" ></Multiselect>
                    <span class="text-danger input_field_err" :id="`input_field_err_${index}`"></span>
                  </div>
                </div>
                <div class="row align-items-end">
                  <InputField class=" col-md-6"  :placeholder="$t('placeholder.input_default_val')" v-model="input.default_value" ></InputField>
                  <div class="form-group col-md-6">
                    <label class="form-label"></label>
                    <div class="d-flex justify-content-between align-items-center"> 
                      <label class="form-label" for="Isrequired-status">{{ $t('customtemplate.lbl_is_required') }}</label>
                      <div class="form-check form-switch">
                        <input class="form-check-input" :value="true" :checked="input.is_required" name="is_required" id="Isrequired-status" type="checkbox" @change="toggleIsRequired(index)" />
                      </div>
                    </div>
                  </div>
                  <div v-if="input.selected === 'single_select' && input.input_type === 'single_select'"  class="form-group col-md-12 " >
                    <fieldset class="bg-body mt-3">
                      <legend>{{$t('customtemplate.select_option_data')}}</legend>
                      <div class="d-md-flex align-items-end gap-3 pb-4 border-bottom" v-for="(option,option_index) in input.option_data" :key="option_index">
                        <div class="flex-grow-1">
                          <div class="row">
                            <div class="form-group col-md-4">
                              <input type="text" class="form-control" placeholder="Enter Option Title" v-model="option.title" />
                              <span class="text-danger option_title_err" :id="`option_title_err_${option_index}`"></span>
                            </div>
                             
                            <div class="form-group col-md-4">
                              <input type="text" class="form-control" placeholder="Enter Option Value" v-model="option.value" />
                              <span class="text-danger option_value_err" :id="`option_value_err_${option_index}`"></span>
                            </div>
                             
                            <div class="form-group col-md-4">
                              <input type="text" class="form-control" placeholder="Enter Option Icon" v-model="option.icon" />
                            </div>
                          </div>
                        </div>
                        <div class="flex-shrink-0 mt-md-0 mt-3" v-if="input.option_data.length>1">
                          <div class="text-end">
                            <button type="button" @click="removeSelectOption(index,option_index)" class="btn btn-danger px-3"><i class="fa-regular fa-trash-can"></i></button>
                          </div> 
                        </div>
                      </div>
                      <span class="text-danger optionlist"></span>
                      <div class="row mt-4">
                        <div class="form-group col-12 text-end">
                          <a @click="addSelectOption(index)" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i>{{$t('customtemplate.add_new_select')}}
                          </a>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                </div>
                <div class="row" v-if="userInputList.length>1">
                  <div class="form-group col-12 text-end">
                    <button type="button" @click="removePerson(index)" class="btn btn-danger px-3"><i class="fa-regular fa-trash-can"></i></button>
                  </div>
                  <div class="col-12">
                    <div class="border-top mt-3 pb-5"></div>
                  </div>
                </div> 
              </div>
               
              <div class="form-group col-md-12 text-end">
                <a @click="addPerson" class="btn btn-primary">
                  <i class="fa-solid fa-plus"></i> {{$t('customtemplate.add_user_input')}}
                </a>
              </div>
            </div>
          </fieldset>
          
          <fieldset>
            <legend>{{ $t('customtemplate.custom_prompt') }}</legend>
            <div class="row">
              <div class="form-group col-md-12">
                <div class="d-flex align-items-center gap-3 flex-wrap mb-3" v-if="userInputList.length > 1">
                  <div v-for="(input, btn_index) in userInputList" :key="btn_index" >
                    <span v-if="input.input_title && input.description && input.input_type" class="btn btn-primary" @click="createCustomPrompts(btn_index)">
                      INPUT-{{ btn_index }}
                    </span>
                  </div>    
                </div>
                <textarea class="form-control" :placeholder="$t('placeholder.custom_prompt')" v-model="custom_prompt" id="custom_prompt"></textarea>
                <span v-if="errorMessages['custom_prompt']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['custom_prompt']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <span class="text-danger">{{ errors.custom_prompt }}</span>
              </div>
            </div>
          </fieldset>
          
        </div>
        <FormFooter></FormFooter>
      </div>
    </form>
  </template>
  <script setup>
  import { ref,computed, watch } from 'vue'
  import { EDIT_URL, STORE_URL, UPDATE_URL, CATEGORY_LIST, SUBSECRIPTION_PLAN_LIST} from '../constant/customtemplate'
  import { useField, useForm } from 'vee-validate'
  import { useSelect } from '@/helpers/hooks/useSelect'
  import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
  import * as yup from 'yup'
  import { readFile } from '@/helpers/utilities'
  import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
  import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
  import InputField from '@/vue/components/form-elements/InputField.vue'

  const props=defineProps({

    createTitle: { type: String, default: '' },
    editTitle: { type: String, default: '' },
    defaultImage: { type: String, default: 'https://dummyimage.com/600x300/cfcfcf/000000.png' },
    customefield: { type: Array, default: () => [] }

   })
  
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
  
  const currentId = useModuleId(() => {
   
    if (currentId.value > 0) {

     getRequest({ url: EDIT_URL, id: currentId.value })
    .then((res) => {
      
        userInputList.value=res.data.userinput_list;  
        if (res.status) {
            setFormData(res.data);
        }
    })

    } else {

      setFormData(defaultData())
    }
  })
  
  const singalSelectOption = ref({
    closeOnSelect: true,
    searchable: true,
  })


 const isSelectInput = ref(false);
 const index_value = ref('');

 const userInputList = ref([{ 
    index:0, 
    input_title: '', 
    description:'', 
    input_type:'', 
    input_tag:'##INPUT-0##', 
    is_required:0, 
    default_value:'',   
    option_data: [{ title: '', value: '', icon: '' }],
    selected: '' 
  }]);

 const isAddInputButtonDisabled = computed(() => {
      return userInputList.value.some((input) => !input.input_title || !input.description || !input.input_type );
    });

  const isAddOptionButtonDisabled = computed(() => {
       return userInputList.value.some((input) => {
         if(input.option_data) {
           return input.option_data.some((option) => !option.title || !option.value );
         }
         return false;
       });
  });
const selected = ref('');
const SelectInput = (index, selectedValue) => {

  if(selectedValue=='single_select'){

    index_value.value=index;
    isSelectInput.value = selectedValue === 'single_select';
    userInputList.value[index].selected = selectedValue;
    selected.value = selectedValue;
  }
  else{
    isSelectInput.value = false;
  }

};
const toggleIsRequired = (index) => {
  const currentValue = userInputList.value[index].is_required;
  userInputList.value[index].is_required = currentValue === 1 ? 0 : 1;
};

const addPerson = () => {

  const newIndex = userInputList.value.length;
  if (!isAddInputButtonDisabled.value) {

        userInputList.value.push({
          index:newIndex,
          input_title: '',
          description: '',
          input_type: null,
          input_tag:'##INPUT-'+newIndex+'##',
          is_required: 0,
          package_id:null,
          default_value: null,
          option_data: [{ title: '', value: '', icon: '' }]
        });

        // document.querySelector('.userinput_list').textContent = '';
        document.querySelector(`#input_title_err_${newIndex-1}`).textContent = '';
        document.querySelector(`#input_desc_err_${newIndex-1}`).textContent =  '';
        document.querySelector(`#input_field_err_${newIndex-1}`).textContent = '';

        document.querySelector(`#option_title_err_${newIndex-1}`).textContent = '';
        document.querySelector(`#option_value_err_${newIndex-1}`).textContent = '';
      }else{

        // const errorMessage = 'Fill all Input value';
        // document.querySelector('.userinput_list').textContent = errorMessage;
        const inputTitleErr = "Input title is required"; 
        const inputDescErr = 'Input description is required';
        const inputFieldErr = 'Input field is required';
        document.querySelector(`#input_title_err_${newIndex-1}`).textContent = inputTitleErr;
        document.querySelector(`#input_desc_err_${newIndex-1}`).textContent = inputDescErr;
        document.querySelector(`#input_field_err_${newIndex-1}`).textContent = inputFieldErr;

      }
};

const removePerson = (index) => {
  userInputList.value.splice(index, 1);
};

const removeSelectOption=(index, option_index)=>{
  userInputList.value[index].option_data.splice(option_index, 1);
}

const addSelectOption = (index) => {
   
  const optionIndex = userInputList.value[index].option_data.length;
   
  if (userInputList.value[index]) {
    const selectedInput = userInputList.value[index];
   
    if (selectedInput.input_type === 'single_select') {
       
      const isValidOption = selectedInput.option_data.every(option => option.title !== '' && option.value !== '' );
      if (isValidOption) {
        
        userInputList.value[index].option_data.push({
          title: '',
          description: '',
          icon: ''
        });
        document.querySelector(`#option_title_err_${optionIndex-1}`).textContent = '';
        document.querySelector(`#option_value_err_${optionIndex-1}`).textContent = '';
      } else {
        
        const optionTitleErr = "Option title is required"; 
        const optionValueErr = 'Option value is required';
        document.querySelector(`#option_title_err_${optionIndex-1}`).textContent = optionTitleErr;
        document.querySelector(`#option_value_err_${optionIndex-1}`).textContent = optionValueErr;
        // console.log('All option fields must be filled');
      }
    } else {
      
      console.log('Input type must be "single_select" to add options');
    }
  }
};

const createCustomPrompts=(btn_index)=>{

  custom_prompt.value=custom_prompt.value +' ##INPUT-'+btn_index +'## '

}

const packages = ref({ options: [], list: [] })


const categories = ref({ options: [], list: [] })

const inputData = ref({ options: [ { value: 'text_input', label: 'Input Field' },
                                   { value: 'textarea', label: 'Textarea Field' },
                                   { value: 'number_input', label: 'Number Input Field' },
                                   { value: 'decimal_input', label: 'Decimal Input Field' },
                                   { value: 'single_select', label: 'Select List Field' }], list: [] })
                                 
useSelect({ url: CATEGORY_LIST }, { value: 'id', label: 'name' }).then((data) => (categories.value = data))

useSelect({ url: SUBSECRIPTION_PLAN_LIST }, { value: 'id', label: 'name' }).then((data) => (packages.value = data))


const ImageViewer = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
  feature_image.value = file
}



  // Default FORM DATA
  const defaultData = () => {
    userInputList.value=[{ index:0, input_title: '', description:'', input_type:'', input_tag:'##INPUT-0##', is_required:0, default_value:'',   option_data: [{ title: '',  value: '', icon: '' }] }]
    errorMessages.value = {}
    return {
      template_name: '',
      description: '',
      category_id: '',
      custom_prompt: '',
      status: 1,
      package_id: null,
      inculde_voice_tone: 1,
      feature_image: null,
    }
  }
  
  //  Reset Form
  const setFormData = (data) => {
    ImageViewer.value = data.feature_image
    resetForm({
      values: {
    
        template_name: data.template_name,
        description: data.description,
        category_id: data.category_id,
        package_id: data.package_id,
        custom_prompt: data.custom_prompt,
        status: data.status,
        inculde_voice_tone: data.inculde_voice_tone,
        feature_image: data.feature_image,

      }
    })
  }
  
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

    // Validations
    const validationSchema = yup.object({
      template_name: yup.string()
      .required('First Name is a required field')
      .test('is-string', 'Only strings are allowed', (value) => {
        // Regular expressions to disallow special characters and numbers
        const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/
        return !specialCharsRegex.test(value)
      }),

      feature_image: yup.string().test('feature_image', 'Template image is required', function (value) {
        if (currentId === 0 && !value) {
            return false;
           }
          return true;
        }).label('Template Image'),

      category_id:yup.string().required('Category is required'),
      custom_prompt:yup.string().required('Custom Prompt is required'),
      package_id:yup.string().required('Package is required'),
      description:yup.string().required('Description is required'),

    })
  
  const { handleSubmit, errors, resetForm } = useForm({
    validationSchema
  })
  const { value: feature_image } = useField('feature_image')
  const { value: template_name } = useField('template_name')
  const { value: description } = useField('description')
  const { value: category_id } = useField('category_id')
  const { value: package_id } = useField('package_id')
  const { value: custom_prompt } = useField('custom_prompt')
  const { value: status } = useField('status')
  const { value: inculde_voice_tone } = useField('inculde_voice_tone')



  const errorMessages = ref({})
  
  // Form Submit
  const formSubmit = handleSubmit((values) => {

    if(!isAddInputButtonDisabled){

       const errorMessage = 'User Input fields are required';
       document.querySelector('.userinput_list').textContent = errorMessage;
        return;
    }

    values.userinput_list = JSON.stringify(userInputList.value)

   if(currentId.value > 0) {
      updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
    } else {
      storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
    }
  })
  
  useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
  </script>
  <style scoped>
  @media only screen and (min-width: 768px) {
    .offcanvas {
      width: 80%;
    }
  }
  
  @media only screen and (min-width: 1280px) {
    .offcanvas {
      width: 60%;
    }
  }
  </style>
  