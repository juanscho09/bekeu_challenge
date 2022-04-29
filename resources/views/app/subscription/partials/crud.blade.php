<div class="callout callout-warning">
    <!--<div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Suscripci&oacute;n</h3>
        </div>-->
        <form id="quickForm" novalidate="novalidate">
            <!--<div class="card-body">-->
            <div class="form-group">
                <label for="tx_email">Email</label>
                <input type="email" name="tx_email" class="form-control" 
                    id="tx_email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="lst_states">Estado</label>
                <select class="form-control select2" style="width: 100%" name="lst_states" id="lst_states">
                    <option value="">Elegir un estado</option>
                    @foreach( $states as $state )
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <!--</div>
            <div class="card-footer">-->
                <button type="button" class="btn btn-primary" id="send_subscription">Enviar</button>
            <!--</div>-->
        </form>
    <!--</div>-->
</div>