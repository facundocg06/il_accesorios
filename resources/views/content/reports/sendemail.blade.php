<form action="{{ route('reports.ventas.email') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="start_date" class="form-label">Fecha de inicio:</label>
            <input type="date" id="start_date" name="start_date" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="end_date" class="form-label">Fecha de fin:</label>
            <input type="date" id="end_date" name="end_date" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="sender" class="form-label">Remitente:</label>
            <input type="email" id="sender" name="sender" class="form-control" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="subject" class="form-label">Asunto:</label>
            <input type="text" id="subject" name="subject" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="recipient" class="form-label">Destinatario:</label>
            <input type="email" id="recipient" name="recipient" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Cuerpo del mensaje:</label>
        <textarea id="body" name="body" rows="5" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enviar reporte por correo</button>
</form>