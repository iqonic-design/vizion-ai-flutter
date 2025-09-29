export const MODULE = 'services'
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}
export const CATEGORY_LIST = ({type=''}) => {return {path: `categories/index_list?type=${type}`, method: 'GET'}}
export const SYSTERM_SERVICE_LIST = (id) => {return {path: `service/systemservice/index_list`, method: 'GET'}}

// Gallery Assign
export const GET_GALLERY_URL = (id) => {return {path: `${MODULE}/gallery-images/${id}`, method: 'GET'}}
export const POST_GALLERY_URL = (id) => {return {path: `${MODULE}/gallery-images/${id}`, method: 'POST'}}
export const SYSTEM_SERVICE_EDIT_URL = (id) => {return {path: `systemservice/${id}/edit`, method: 'GET'}}
export const SYSTEM_SERVICE_UPDATE_URL = (id) => {return {path: `systemservice/${id}`, method: 'POST'}}




