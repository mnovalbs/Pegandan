import axios from 'axios';

const apiUrl = str => '/api' + str;

export default {
  patient: {
    list: () => axios.get(apiUrl('/patient')),
    update: (id, data) => axios.patch(apiUrl(`/patient/${id}`), data),
    create: data => axios.post(apiUrl('/patient'), data)
  }
}