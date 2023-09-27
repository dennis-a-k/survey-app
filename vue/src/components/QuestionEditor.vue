<template>
  <div>
    <!-- индекс -->
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-bold">{{ index + 1 }}. {{ model.question }}</h3>

      <div class="flex items-center">
        <!-- добавить вопрос -->
        <button
          type="button"
          @click="addQuestion()"
          class="flex items-center text-xs py-1 px-3 mr-2 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
              clip-rule="evenodd"
            />
          </svg>
          Добавить
        </button>
        <!--/ добавить вопрос -->

        <!-- удалить вопрос -->
        <button
          type="button"
          @click="deleteQuestion()"
          class="flex items-center text-xs py-1 px-3 rounded-sm border border-transparent text-red-500 hover:border-red-600"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"
            />
          </svg>
          Удалить
        </button>
        <!--/ удалить вопрос -->
      </div>
    </div>
    <!--/ индекс -->

    <div class="grid gap-3 grid-cols-12">
      <!-- вопрос -->
      <div class="mt-3 col-span-9">
        <label
          :for="'question_text_' + model.data"
          class="block text-sm font-medium text-gray-700"
          >Вопрос</label
        >
        <input
          type="text"
          :name="'question_text_' + model.data"
          v-model="model.question"
          @change="dataChange"
          :id="'question_text_' + model.data"
          class="mt-1 focus:ring-sky-800 focus:border-sky-800 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        />
      </div>
      <!--/ вопрос -->

      <!-- тип -->
      <div class="mt-3 col-span-3">
        <label
          for="question_type"
          class="block text-sm font-medium text-gray-700"
        >
          Тип
        </label>
        <select
          id="question_type"
          name="question_type"
          v-model="model.type"
          @change="typeChange"
          class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 sm:text-sm"
        >
          <option
            v-for="questionType in questionTypes"
            :key="questionType"
            :value="questionType"
          >
            {{ upperCaseFirst(questionType) }}
          </option>
        </select>
      </div>
      <!--/ тип -->
    </div>

    <!-- описание -->
    <div class="mt-3 col-span-9">
      <label
        :for="'question_description_' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Описание</label
      >
      <textarea
        :name="'question_description_' + model.id"
        v-model="model.description"
        @change="dataChange"
        :id="'question_description_' + model.id"
        class="mt-1 focus:ring-sky-800 focus:border-sky-800 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      />
    </div>
    <!--/ описание -->

    <!-- данные -->
    <div>
      <div v-if="shouldHaveOptions()" class="mt-2">
        <h4
          class="text-sm font-semibold mb-1 flex justify-between items-center"
        >
          Параметры

          <!-- добавить параметр -->
          <button
            type="button"
            @click="addOption()"
            class="flex items-center text-xs py-1 px-2 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                clip-rule="evenodd"
              />
            </svg>
            Добавить параметр
          </button>
          <!--/ добавить параметр -->
        </h4>

        <!-- <div
          v-if="!model.data.options.length"
          class="text-xs text-gray-600 text-center py-3"
        >
          Параметры не добавлены
        </div> -->

        <!-- список параметров -->
        <div
          v-for="(option, index) in model.data.options"
          :key="option.uuid"
          class="flex items-center mb-1"
        >
          <span class="w-6 text-sm"> {{ index + 1 }}. </span>
          <input
            type="text"
            v-model="option.text"
            @change="dataChange"
            class="w-full rounded-sm py-1 px-2 text-xs border border-gray-300 focus:border-sky-800"
          />

          <!-- удалить параметр -->
          <button
            type="button"
            @click="removeOption(option)"
            class="h-6 w-6 rounded-full flex items-center justify-center border border-transparent transition-colors hover:border-red-100"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-3 w-3 text-red-500"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
          <!--/ удалить параметр -->
        </div>
        <!--/ список параметров -->
      </div>
    </div>
    <!--/ данные -->

    <hr class="my-4" />
  </div>
</template>

<!-- <script>
import { computed } from "vue";
import { v4 as uuidv4 } from "uuid";

export default {
  name: "QuestionEditor",
  props: {
    question: Object,
    index: Number,
  },
  emits: ["change", "addQuestion", "deleteQuestion"],
  data: () => ({
    model: {},
    questionTypes: [],
  }),
  mounted() {
    this.model = JSON.parse(JSON.stringify(this.question));
    this.questionTypes = computed(() => this.$store.state.questionTypes);
  },
  methods: {
    upperCaseFirst(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    },

    shouldHaveOptions() {
      return ["select", "radio", "checkbox"].includes(this.model.type);
    },

    getOptions() {
      return this.model.data.options;
    },

    setOptions(options) {
      this.model.data.options = options;
    },

    addOption() {
      setOptions([...getOptions(), { uuid: uuidv4(), text: "" }]);
      dataChange();
    },

    removeOption(op) {
      setOptions(getOptions().filter((opt) => opt !== op));
      dataChange();
    },

    typeChange() {
      if (shouldHaveOptions()) {
        setOptions(getOptions() || []);
      }
      dataChange();
    },

    dataChange() {
      // const data = this.model;
      const data = JSON.parse(JSON.stringify(this.model));

      if (!shouldHaveOptions()) {
        delete data.data.options;
      }

      this.$emit("change", data);
    },

    addQuestion() {
      this.$emit("addQuestion", this.index + 1);
    },

    deleteQuestion() {
      this.$emit("deleteQuestion", this.question);
    },
  },
};
</script> -->

<script setup>
import { v4 as uuidv4 } from "uuid";
import { computed, ref } from "@vue/reactivity";
import store from "../store";

const props = defineProps({
  question: Object,
  index: Number,
});

const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);

// Re-create the whole question data to avoid unintentional reference change
const model = ref(JSON.parse(JSON.stringify(props.question)));

// Get question types from vuex
const questionTypes = computed(() => store.state.questionTypes);

function upperCaseFirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function getOptions() {
  return model.value.data.options;
}

function setOptions(options) {
  model.value.data.options = options;
}

// Check if the question should have options
function shouldHaveOptions() {
  return ["select", "radio", "checkbox"].includes(model.value.type);
}

// Add option
function addOption() {
  setOptions([...getOptions(), { uuid: uuidv4(), text: "" }]);
  dataChange();
}

// Remove option
function removeOption(op) {
  setOptions(getOptions().filter((opt) => opt !== op));
  dataChange();
}

function typeChange() {
  if (shouldHaveOptions()) {
    setOptions(getOptions() || []);
  }
  dataChange();
}

// Emit the data change
function dataChange() {
  // const data = model.value;
  const data = JSON.parse(JSON.stringify(model.value));

  if (!shouldHaveOptions()) {
    delete data.data.options;
  }

  emit("change", data);
}

function addQuestion() {
  emit("addQuestion", props.index + 1);
}

function deleteQuestion() {
  emit("deleteQuestion", props.question);
}
</script>
