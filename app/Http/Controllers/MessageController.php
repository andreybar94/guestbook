<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\User;
use Validator;
use GuzzleHttp\Client; 

class MessageController extends Controller
{
    public function index()
    {
        $data = array('title' => 'Гостевая книга',
                      'pagetitle'  => 'Гостевая книга',
                      'messages' => Message::latest()->paginate(5),
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
        if (!$this->checkRecaptcha($input['g-recaptcha-response'], $request->ip())) {
                        return redirect()
                            ->route('messages')
                            ->withErrors('Капча недействительна.')
                            ->withInput(); // Даннные, которые вводили
        }    

        $message = new Message();

        //Получаем id авторизованного пользователя
        $userId = Auth::user()->id; 
        
        $message->user_id = $userId;
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
        // Осуществляем проверку данных
        $validator = Validator::make(
                        $input, 
                        array(
                            'message' => 'required',
                        ));
        if ($validator->fails()) {
            // Проверка не пройдена
            return redirect(route('messages'))
                            ->withErrors($validator) // Сообщения об ошибках
                            ->withInput(); // Даннные, которые вводили
        }
        // Проверка пройдена
        return NULL;
    }

    private function checkRecaptcha($token, $ip)
    {
        $response = (new Client)->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret'   => config('recaptcha.secret'),
                'response' => $token,
                'remoteip' => $ip,
            ],
        ]);
        $response = json_decode((string)$response->getBody(), true);
        return $response['success'];
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()
                        ->route('messages')
                        ->with('sessionMessage', 'Запись удалена.');
    }   
}
