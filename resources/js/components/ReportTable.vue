<template>
  <div>
    <panel title="Report">
      <date-picker v-model="timeRange" range></date-picker>
      <span v-if="loading">Loading...</span>
      <b-table v-else striped hover :items="filteredList" :fields="fields">
        <template v-slot:cell(patient)="row">
          {{ row.item.patient.name }}
        </template>

        <template v-slot:cell(indicator)="row">
          {{ row.item.indicator.name }}
        </template>

        <template v-slot:cell(date)="row">
          {{ row.item.reported_at }}
        </template>

        <template v-slot:cell(status)="row">
          <div>
            <b-badge v-if="row.item.status" variant="success" class="bg-success">Complete</b-badge>
            <b-badge v-else variant="warning" class="bg-warning">Incomplete</b-badge>
          </div>
        </template>

        <template v-slot:cell(steps)="row">
          {{ row.item.steps.filter(step => step.status).length }} / {{ row.item.steps.length }}
        </template>

        <template v-slot:cell(action)="row">
          <div>
            <b-button @click="edit(row)">Edit</b-button>
            <b-button size="sm" @click="requestDelete(row)" class="btn btn-danger">Delete</b-button>
          </div>
        </template>
      </b-table>
    </panel>

    <b-modal id="modal-edit" title="Edit Report" hide-footer>
      <report-form :form="dataEdit" isEdit :loading="submitLoading" @submit="doEdit"></report-form>
    </b-modal>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import ReportForm from "./ReportForm";
import Panel from "./Panel";
import API from "../interface";

const defaultData = {
  patient_id: 0,
  indicator_id: 0,
  reported_at: '',
  steps_id: []
};

export default {
  name: "ReportApp",

  data() {
    return {
      submitLoading: false,

      dataEdit: {},
      timeRange: [
        moment().startOf('month').toDate(),
        moment().endOf('month').toDate()
      ],
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
      return ["id", "patient", "indicator", "date", "status", "steps", "action"];
    },

    filteredList() {
      const list = this.list;
      return list.filter(l => {
        const reportedAt = (new Date(l.reported_at + " 00:00:00")).getTime();
        const timePrev = this.timeRange[0].getTime();
        const timeNext = this.timeRange[1].getTime();

        return reportedAt <= timeNext && reportedAt >= timePrev;
      });
    }
  },

  components: {
    DatePicker,
    ReportForm,
    Panel
  },

  methods: {
    edit(row) {
      const { item } = row;
      const data = {
        id: item.id,
        patient_id: item.patient_id,
        indicator_id: item.indicator_id,
        reported_at: item.reported_at,
        steps_id: item.steps.filter(step => step.status).map(step => step.indicator_step_id)
      }

      this.dataEdit = Object.assign({}, data);
      this.$bvModal.show("modal-edit");
    },

    async requestDelete(row) {
      const { id } = row.item;
      const conf = confirm(`Delete report?`);
      if (!conf) return;
      try {
        await API.report.delete(id);
        this.$emit('requestUpdate');
      } catch (e) {
        alert(`Tidak berhasil menghapus indicator`);
      }
    },

    async doEdit() {
      try {
        this.submitLoading = true;
        await API.report.update(this.dataEdit.id, this.dataEdit);
        this.$bvModal.hide("modal-edit");
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