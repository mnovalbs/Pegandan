import axios from 'axios';

const apiUrl = str => '/api' + str;

export default {
  patient: {
    list: () => axios.get(apiUrl('/patient'))
  }
}