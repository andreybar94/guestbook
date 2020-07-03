<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Validator; 

class HomeController extends Controller
{
	public function index()
	{

		$data = array('title' => 'Гостевая книга',
					  'pagetitle'  => 'Гостевая книга',
					  'messages' => Message::latest()->get()
					);
	
    	return view('pages.index',$data);
	}

	public function store(Request $request) 
	{
        // Данные отправленные через форму
        $input = $request->all();

        $validationResult = $this->_validation($input);


        if (!is_null($validationResult)) {
            return $validationResult;
        } 
        $message = new Message();

        $message->username = 'name';
        $message->message = $input['message'];

        if ($message->save()) {
            return redirect()
                            ->route('messages')
                            ->with('sessionMessage', 'Запись добавлена.');
        }
        // Если во время записи произойдёт ошибка, отобразим ошибку 500.
        abort(500);
    }

    private function _validation($input) 
    {
        $validatorErrorMessages = array(
            'required' => 'Поле :attribute обязательно к заполнению',
        );

        // Осуществляем проверку данных
        $validator = Validator::make(
                        $input, 
                        array(
                            'message' => 'required',
                        ),
                        $validatorErrorMessages);
        if ($validator->fails()) {
            // Проверка не пройдена
            return redirect(route('messages'))
                            ->withErrors($validator) // Сообщения об ошибках
                            ->withInput(); // Даннные, которые вводили
        }
        // Проверка пройдена
        return NULL;
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()
                        ->route('messages')
                        ->with('sessionMessage', 'Запись удалена.');
    }	
}
