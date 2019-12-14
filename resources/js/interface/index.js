import axios from 'axios';

const apiUrl = str => '/api' + str;

export default {
  patient: {
    list: () => axios.get(apiUrl('/patient')),
    update: (id, data) => axios.patch(apiUrl(`/patient/${id}`), data),
    create: data => axios.post(apiUrl('/patient'), data)
  },

  indicators: {
    list: () => axios.get(apiUrl('/indicator')),
    update: (id, data) => axios.patch(apiUrl(`/indicator/${id}`), data),
    create: data => axios.post(apiUrl('/indicator'), data),
    detail: id => axios.get(apiUrl(`/indicator/${id}`)),
    delete: id => axios.delete(apiUrl(`/indicator/${id}`)),

    step: {
      list: indicator_id => axios.get(apiUrl(`/indicator/${indicator_id}`)),
      create: data => axios.post(apiUrl('/indicator-step'), data),
      update: (id, data) => axios.patch(apiUrl(`/indicator-step/${id}`), data),
      delete: id => axios.delete(apiUrl(`/indicator-step/${id}`))
    }
  }
}