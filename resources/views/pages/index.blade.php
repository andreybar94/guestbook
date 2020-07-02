@extends('index')

    @section('content')
    <form method="POST" id="id-form_messages">

        <div class="form-group">
            <label for="message">Сообщение: *</label>
            <textarea class="form-control" rows="5" placeholder="Текст сообщения" name="message" cols="50"
                      id="message"></textarea>
        </div>

        <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Добавить">
        </div>

        <div class="messages">
				
			<div class="card">
			  <div class="card-header d-flex justify-content-between flex-wrap">
			    <span>Username</span>
                <span>17:15:00 / 03.07.2016</span>
			  </div>
			  <div class="card-body">
			    <p class="card-text">
			    	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt, iste nostrum blanditiis, cupiditate laborum fuga quisquam quas praesentium veritatis architecto recusandae, similique cumque sed illo beatae consequatur delectus vel reprehenderit.</p>
			    <button type="button" class="btn btn-danger">Удалить</button>
			  </div>
			</div>
        </div>
    </form>
    @stop