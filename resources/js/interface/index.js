import axios from 'axios';

const apiUrl = str => '/api' + str;

export default {
  patient: {
    list: () => axios.get(apiUrl('/patient')),
    detail: id => axios.get(apiUrl(`/patient/${id}`)),
    update: (id, data) => axios.patch(apiUrl(`/patient/${id}`), data),
    create: data => axios.post(apiUrl('/patient'), data)
  },

  kelurahan: {
    list: () => axios.get(apiUrl('/kelurahan')),
    update: (id, data) => axios.patch(apiUrl(`/kelurahan/${id}`), data),
    create: data => axios.post(apiUrl('/kelurahan'), data),
    delete: id => axios.delete(apiUrl(`/kelurahan/${id}`))
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
  },

  report: {
    list: () => axios.get(apiUrl('/report')),
    create: data => axios.post(apiUrl(`/report`), data),
    delete: id => axios.delete(apiUrl(`/report/${id}`)),
    update: (id, data) => axios.patch(apiUrl(`/report/${id}`), data),
    indicator: (dateStart, dateEnd) => axios.get(apiUrl(`/report/indicators?date_start=${dateStart}&date_end=${dateEnd}`))
  }
}