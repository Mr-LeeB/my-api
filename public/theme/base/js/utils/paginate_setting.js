Vue.component('setup-paginate', {
    props: {
        current_page: Number,
        last_page: Number,
    },
    methods: {
        changePage(page) {
            if (page == this.current_page || (page == -1 && this.current_page == null)) {
                return;
            }
            if (page == 1) {
                $(".previous").addClass("disabled");
                $(".previous").removeClass("cursor-pointer");
            } else {
                $(".previous").removeClass("disabled");
                $(".previous").addClass("cursor-pointer");
            }

            if (page == this.last_page) {
                $(".next").addClass("disabled");
                $(".next").removeClass("cursor-pointer");
            } else {
                $(".next").removeClass("disabled");
                $(".next").addClass("cursor-pointer");
            }

            this.$emit('handle_change', page);
        },
        cssPagination(page) {
            if (page == this.current_page || (page == 1 && this.current_page == null)) {
                return {
                    'background-color': '#3699FF',
                    'color': 'white',
                };
            }
        },
    },
    template: `
                <div class="paginate">
                    <nav aria-label="navigation">
                        <ul class="pagination">
                            <li class="page-item previous disabled">
                                <div class="page-link" aria-label="Previous"
                                    @click="changePage(current_page-1)">
                                    <span aria-hidden="true">&laquo;</span>
                                </div>
                            </li>
                            <li class="page-item cursor-pointer" v-for="page in last_page">
                                <div class="page-link" @click="changePage(page)" :style="cssPagination(page)">
                                    {{ page }}
                                </div>
                            </li>
                            <li class="page-item cursor-pointer next">
                                <div class="page-link" aria-label="Next" @click="changePage(current_page+1)">
                                    <span aria-hidden="true">&raquo;</span>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            `,
})