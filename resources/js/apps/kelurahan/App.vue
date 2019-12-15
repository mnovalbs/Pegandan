<template>
  <div>
    <b-button class="btn btn-primary btn-create" @click="$bvModal.show('modal-create')">Create new Kelurahan</b-button>

    <panel title="Kelurahan">
      <b-table striped hover :items="list" :fields="fields">
        <template v-slot:cell(action)="row">
          <div>
            <b-button size="sm" @click="edit(row)">Edit</b-button>
            <b-button size="sm" @click="requestDelete(row)" class="btn btn-danger">Delete</b-button>
          </div>
        </template>
      </b-table>
    </panel>

    <b-modal id="modal-edit" title="Edit Kelurahan" hide-footer>
      <kelurahan-form :form="dataEdit" :loading="submitLoading" @submit="doEdit"></kelurahan-form>
    </b-modal>

    <b-modal id="modal-create" title="Create new Kelurahan" hide-footer>
      <kelurahan-form :form="dataAdd" :loading="submitLoading" @submit="doCreate"></kelurahan-form>
    </b-modal>
  </div>
</template>

<script>
import KelurahanForm from './KelurahanForm';
import Panel from "../../components/Panel";
import API from "../../interface";

const defaultData = {
  name: '',
}

export default {
  name: "KelurahanApp",

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
      return ["id", "name", "step", "action"];
    }
  },

  components: {
    KelurahanForm,
    Panel
  },

  methods: {
    async requestDelete(row) {
      const { name, id } = row.item;
      const conf = confirm(`Delete kelurahan ${name}?`);
      if (!conf) return;
      try {
        await API.kelurahan.delete(id);
        this.fetchData();
      } catch (e) {
        alert(`Tidak berhasil menghapus kelurahan ${name}`);
      }
    },

    edit(row) {
      const { id } = row.item;
      const data = this.list.find(patient => patient.id === id);

      this.dataEdit = Object.assign({}, data);
      this.$bvModal.show('modal-edit');
    },

    async doEdit() {
      try {
        this.submitLoading = true;
        await API.kelurahan.update(this.dataEdit.id, this.dataEdit);
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
        await API.kelurahan.create(this.dataAdd);
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
      const { data } = await API.kelurahan.list();
      this.list = data.data;
      this.loading = false;
    }
  }
};
</script>

<style lang="scss" scoped>
.btn-create {
  margin-bottom: 10px;
}
</style>