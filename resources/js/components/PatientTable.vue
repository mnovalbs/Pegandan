<template>
  <div>
    <panel title="Pasien">
      <span v-if="loading">Loading...</span>
      <b-table v-else striped hover :items="list" :fields="fields">
        <template v-slot:cell(action)="row">
          <div>
            <b-button size="sm" @click="edit(row)">Edit</b-button>
            <router-link :to="`/patient/${row.item.id}`">
              <b-button size="sm" class="btn btn-primary">Detail</b-button>
            </router-link>
          </div>
        </template>

        <template v-slot:cell(kelurahan)="row">
          <span>
            {{ row.item.kelurahan && row.item.kelurahan.name || '-' }}
          </span>
        </template>
      </b-table>
    </panel>

    <b-modal id="modal-edit" title="Edit Patient" hide-footer>
      <patient-form :form="dataEdit" :loading="submitLoading" @submit="doEdit"></patient-form>
    </b-modal>
  </div>
</template>

<script>
import PatientForm from './PatientForm';
import Panel from "./Panel";
import API from "../interface";

export default {
  name: "PatientTable",

  data() {
    return {
      submitLoading: false,

      dataEdit: {},
    };
  },

  props: {
    list: {
      type: Array,
      default: () => []
    },

    loading: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    fields() {
      return ["id", "name", "birth_date", "sex", "age", "kelurahan", "action"];
    }
  },

  components: {
    PatientForm,
    Panel
  },

  methods: {
    edit(row) {
      const { id } = row.item;
      const data = this.list.find(patient => patient.id === id);

      this.dataEdit = Object.assign({}, data);
      this.$bvModal.show('modal-edit');
    },

    async doEdit() {
      try {
        this.submitLoading = true;
        await API.patient.update(this.dataEdit.id, this.dataEdit);
        this.$bvModal.hide('modal-edit');
        this.$emit('requestUpdate');
      } catch (e) {
        alert(e.response.data.message);
      } finally {
        this.submitLoading = false;
      }
    },
  }
};
</script>