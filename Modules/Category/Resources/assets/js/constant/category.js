export const MODULE = 'categories'
export const INDEX_LIST_URL = ({type=''}) => {return {path: `${MODULE}/index_list?type=${type}`, method: 'GET'}}
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}

export const SYSTERM_SERVICE_LIST = (id) => {return {path: `service/systemservice/index_list`, method: 'GET'}}
