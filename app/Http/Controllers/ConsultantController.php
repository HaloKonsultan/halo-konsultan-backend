<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultant;
use App\ConsultantEducation;
use App\ConsultantExperience;
use App\ConsultantSkill;
use App\ConsultantVirtualAccount;
use App\Http\Resources\ConsultantResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class ConsultantController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['except' => [
            'login', 
            'register', 
            'logout',
        ]]);
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
            'name' => ['required','string'],
            'email' => ['required','email','unique:consultants'],
            'password' => ['required'],
            ]);

            $data = new Consultant;
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->password = Hash::make($request->input('password'));

            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'registered',
                'data' => $data
            ],201);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'register failed',
            ], 403);
        }
    }

    public function login(Request $request) 
    {
        try {
            $request->validate([
                'email' => ['required','email'],
                'password' => ['required'],
            ]);
            $email = $request->input('email');
            $password = $request->input('password');
            $data = Consultant::where('email', $email)->first();
    
            if(Hash::check($password, $data->password))
            {
                if(! $token = auth()->login($data)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                } else {
                    $consultant = Consultant::where('email', $request->email)->first();
                    $consultant->device_token =  $request->device_token;
                    $consultant->save();
                    return $this->respondWithToken($token, $data);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Login failed'
                ],401);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'Login failed'
            ],401);
        }
    }

    public function profile($id) {
        try {
            $data =  Consultant::findOrFail($id);
            return response()->json([
                'code' => 200,
                'data' => new ConsultantResource($data)
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function update(Request $request, $id) {
        if(Gate::denies('update-data-consultant', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'gender' => ['required','string'],
            'province' => ['required', 'string'],
            'city' => ['required','string'],
            'consultant_type' => ['required', 'integer'],
            'consultant_experience.id' => ['integer'],
            'consultant_experience.position' => ['string'],
            'consultant_experience.start_year' => ['string'],
            'consultant_experience.end_year' => ['string'],
            'consultant_skills.id' => ['integer'],
            'consultant_skills.skills' => ['string'],
            'consultant_educations.id' => ['integer'],
            'consultant_educations.institution_name' => ['string'],
            'consultant_educations.major' => ['string'],
            'consultant_educations.start_year' => ['string'],
            'consultant_educations.end_year' => ['string'],
        ]);

        $data = Consultant::findOrFail($id);
        foreach($request->consultant_experience as $experience) {
            if($experience["id"] < 0) {
                $consultantExperience = new ConsultantExperience();
                $consultantExperience->consultant_id = $id;
                $consultantExperience->position = $experience["position"];
                if($experience["start_year"] == Carbon::now()->format('Y')) {
                    $consultantExperience->start_year = "Now";
                } else {
                    $consultantExperience->start_year = $experience["start_year"];
                }
    
                if($experience["end_year"] < $experience["start_year"]) {
                    return response()->json([
                        'code' => 400,
                        'Message' => 'End year less than start year'
                    ]);
                } else {
                    $consultantExperience->end_year = $experience["end_year"];
                }
                $consultantExperience->save();
            } else {
                $consultantExperience = ConsultantExperience::find($experience["id"]);
                $consultantExperience->consultant_id = $id;
                $consultantExperience->position = $experience["position"];
                if($experience["start_year"] == Carbon::now()->format('Y')) {
                    $consultantExperience->start_year = "Now";
                } else {
                    $consultantExperience->start_year = $experience["start_year"];
                }
    
                if($experience["end_year"] < $experience["start_year"]) {
                    return response()->json([
                        'code' => 400,
                        'Message' => 'End year less than start year'
                    ]);
                } else {
                    $consultantExperience->end_year = $experience["end_year"];
                }
                $consultantExperience->save();
            }  
        }

        foreach($request->consultant_skills as $skills) {
            if($skills["id"] < 0) {
                $consultantSkills = new ConsultantSkill();
                $consultantSkills->consultant_id = $id;
                $consultantSkills->skills = $skills["skills"];
                $consultantSkills->save();
            } else {
                $consultantSkills = ConsultantSkill::find($skills["id"]);
                $consultantSkills->consultant_id = $id;
                $consultantSkills->skills = $skills["skills"];
                $consultantSkills->save();
            }
            
        }

        foreach($request->consultant_educations as $education) {
            if($education["id"] < 0) {
                $consultantEducation = new ConsultantEducation();
                $consultantEducation->consultant_id = $id;
                $consultantEducation->institution_name = $education["institution_name"];
                $consultantEducation->major = $education["major"];
                if($education["start_year"] == Carbon::now()->format('Y')) {
                    $consultantEducation->start_year = "Now";
                } else {
                    $consultantEducation->start_year = $education["start_year"];
                }
                
                if($education["end_year"] < $education["start_year"]) {
                    return response()->json([
                        'code' => 400,
                        'Message' => 'End year less than start year'
                    ]);
                } else {
                    $consultantEducation->end_year = $education["end_year"];
                }
                $consultantEducation->save();
            }else {
                $consultantEducation = ConsultantEducation::find($education["id"]);
                $consultantEducation->consultant_id = $id;
                $consultantEducation->institution_name = $education["institution_name"];
                $consultantEducation->major = $education["major"];
                if($education["start_year"] == Carbon::now()->format('Y')) {
                    $consultantEducation->start_year = "Now";
                } else {
                    $consultantEducation->start_year = $education["start_year"];
                }
                
                if($education["end_year"] < $education["start_year"]) {
                    return response()->json([
                        'code' => 400,
                        'Message' => 'End year less than start year'
                    ]);
                } else {
                    $consultantEducation->end_year = $education["end_year"];
                }
                $consultantEducation->save();
            }
        }

        $data->name = $request->input('name');
        $data->description = $request->input('description');
        $data->gender = $request->input('gender');
        $data->province = $request->input('province');
        $data->city = $request->input('city');
        $data->category_id = $request->input('consultant_type');
        $data->save();
        return response()->json([
            'code' => 200,
            'data' => new ConsultantResource($data)
        ]);
    }

    public function uploadImage(Request $request, $id) {
        if(Gate::denies('update-data-consultant', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $request->validate([
            'photo' => ['image','mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $data = Consultant::findOrFail($id);
        $imageName = Str::random(50) . "." . $request->photo->extension();
        $path = public_path('images/');
        $request->photo->move($path, $imageName);
        $image = "images/" . $imageName;
        $data->photo = $image;
        $data->save();
        return response()->json([
            'code' => 200,
            'data' => new ConsultantResource($data)
        ]);
    }

    public function consultation(Request $request, $id) {
        if(Gate::denies('update-data-consultant', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $request->validate([
            'chat_price' => ['numeric'],
            'consultation_price' => ['numeric'],
            'consultation_virtual_account.id' => ['integer'],
            'consultation_virtual_account.card_number' => ['numeric'],
            'consultation_virtual_account.bank' => ['string'],
            'consultation_virtual_account.name' => ['string']
        ]);

        
        $data = Consultant::findOrFail($id);
        foreach($request->consultation_virtual_account as $va) {
            if($va["id"] < 0) {
                $consultantVA = new ConsultantVirtualAccount();
                $consultantVA->consultant_id = $id;
                $consultantVA->card_number = $va["card_number"];
                $consultantVA->bank = $va["bank"];
                $consultantVA->name = $va["name"];
                $consultantVA->save();
            } else {
                $consultantVA = ConsultantVirtualAccount::find($va["id"]);
                $consultantVA->consultant_id = $id;
                $consultantVA->card_number = $va["card_number"];
                $consultantVA->bank = $va["bank"];
                $consultantVA->name = $va["name"];
                $consultantVA->save();
            }
        }

        $data->chat_price = $request->input('chat_price');
        $data->consultation_price = $request->input('consultation_price');
        $data->save();
        return response()->json([
            'code' => 200,
            'data' => new ConsultantResource($data)
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $email = auth('consultants-api')->user()->email;
        $data = Consultant::where('email', $email)->first();
        $data->device_token = "";
        $data->save();
        auth('consultants-api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$data)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'data' => $data
        ]);
    }

    public function refresh() {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token, true);
        return response()->json([
            'code' => 200,
            'access_token' => $newToken 
        ], 200);
    }
}
