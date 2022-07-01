<template>
    <li class="nav-item dropdown no-arrow mx-1" role="presentation">
            <a class="dropdown-toggle nav-link" id="drop"  data-toggle="dropdown" aria-expanded="false">
                <span class="badge badge-danger badge-counter" id="badge"></span>
                <i class="fas fa-bell fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in" role="menu" id="notifications">
                <h6 class="dropdown-header">alerts center</h6>
            </div>
    </li>
</template>

<script>
import axios from "axios";
import moment from "moment";
    export default {
        mounted() {
            axios.get('/api/notifications',{headers: {'Accept':'application/json'}}).then((res) => {
                if (res.data.length > 0) {
                        document.getElementById('badge').innerHTML = res.data.length
                        for (let i = 0; i < res.data.length; i++) {
                            const e = res.data[i];
                            $(`<a class="d-flex align-items-center dropdown-item" href="https://vitamventure.com/late-payments">
                            <div class="mr-3">
                                <div class="bg-danger icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                            </div>
                                <p>Alerta de mora: El vehiculo de placa ${e.placa} no recibe pagos desde ${moment(e.created_at, "YYYYMMDD").locale('es_CO').fromNow()}. Comuniquese con el cliente ${e.client.name} ${e.client.last_name}.</p>
                            </div>
                        </a>`).appendTo('#notifications');

                    }
                }
            })
        },
        methods: {
        }
    }
</script>
