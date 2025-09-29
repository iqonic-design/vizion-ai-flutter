export const MODULE = 'custom-templates'
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}

export const CATEGORY_LIST = ({type='ai_writer'}) => {return {path: `categories/index_list?type=${type}`, method: 'GET'}}
export const SUBSECRIPTION_PLAN_LIST = (id) => {return {path: `subscription/plans/index_list`, method: 'GET'}}




 