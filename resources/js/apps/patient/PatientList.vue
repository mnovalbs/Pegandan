<template>
  <div>
    <b-button class="btn btn-primary btn-create" @click="$bvModal.show('modal-create')">Create new patient</b-button>

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

    <b-modal id="modal-create" title="Create new Patient" hide-footer>
      <patient-form :form="dataAdd" :loading="submitLoading" @submit="doCreate"></patient-form>
    </b-modal>
  </div>
</template>

<script>
import PatientForm from './PatientForm';
import Panel from "../../components/Panel";
import API from "../../interface";

const defaultData = {
  name: '',
  birth_date: '',
  sex: 'MALE',
  kelurahan_id: null
}

export default {
  name: "PatientList",

  data() {
    return {
      submitLoading: false,
      loading: true,
      list: [],

      dataEdit: {},
      dataAdd: Object.assign(defaultData)
    };
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

  mounted() {
    this.fetchData();
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
        this.fetchData();
      } catch (e) {
        alert(e.response.data.message);
      } finally {
        this.submitLoading = false;
      }
    },

    async doCreate() {
      try {
        this.submitLoading = true;
        await API.patient.create(this.dataAdd);
        this.dataAdd = Object.assign(defaultData);
        this.$bvModal.hide('modal-create');
        this.fetchData();
      } catch (e) {
        alert(e.response.data.message);
      } finally {
        this.submitLoading = false;
      }
    },

    async fetchData() {
      try {
        this.loading = true;
        const { data } = await API.patient.list();
        this.list = data.data;
      } catch (e) {
        alert("Error while fetching patient data");
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.btn-create {
  margin-bottom: 10px;
}
</style>