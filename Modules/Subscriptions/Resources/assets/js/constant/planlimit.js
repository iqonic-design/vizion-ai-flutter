export const MODULE = 'planlimitation'
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/update-planlimit/${id}`, method: 'POST'}}

export const SYSTERM_SERVICE_LIST = () => {return {path: `${MODULE}/system-service-list`, method: 'GET'}}
export const CATEGORY_LIST = () => {return {path: `${MODULE}/category-list`, method: 'GET'}}



