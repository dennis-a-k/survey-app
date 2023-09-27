<template>
  <div>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img
        class="mx-auto h-10 w-auto"
        src="../assets/images/free-icon-notebook-6780593.png"
        alt="Your Company"
      />
      <h2
        class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
      >
        Регистрация
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="register">
        <div>
          <label
            for="name"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Имя
          </label>
          <div class="mt-2">
            <input
              id="name"
              v-model="user.name"
              type="text"
              autocomplete="name"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-800 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <label
            for="email"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Почта
          </label>
          <div class="mt-2">
            <input
              id="email"
              v-model="user.email"
              type="email"
              autocomplete="email"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-800 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label
              for="password"
              class="block text-sm font-medium leading-6 text-gray-900"
              >Пароль
            </label>
          </div>
          <div class="mt-2">
            <input
              id="password"
              v-model="user.password"
              type="password"
              autocomplete="current-password"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-800 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label
              for="password_confirmation"
              class="block text-sm font-medium leading-6 text-gray-900"
              >Повторите пароль
            </label>
          </div>
          <div class="mt-2">
            <input
              id="password_confirmation"
              v-model="user.password_confirmation"
              type="password"
              autocomplete="current-password_confirmation"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-800 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="flex w-full justify-center rounded-md bg-sky-800 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-sky-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-800"
          >
            Зарегистрироваться
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        <router-link
          :to="{ name: 'Login' }"
          class="font-semibold leading-6 text-sky-800 hover:text-sky-700"
          >Войти
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Register",
  data: () => ({
    user: {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
    },
  }),
  methods: {
    register() {
      this.$store.dispatch("register", this.user).then((res) => {
        this.$router.push({ name: "Dashboard" });
      });
    },
  },
};
</script>
