<?php namespace Model;

use Hash;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    use Traits\Act;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

/*             public function message()
            {
                return $this->hasMany('Message', 'user');
            }        
    */
    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
            return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
            return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
            return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
            $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
            return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
            return $this->email;
    }

    public function setPasswordAttribute($password)
    {

        $this->attributes['password'] = Hash::make($password);

    }
     
    public function getSettings($param = null)
    {
        $site = Model\Site::path('profile', true, false);
        
        $return = empty($site) ? Model\Site::find(1)->settings : $site->settings;
        // costl
        if (empty($return['image'])) {
            $mainPageSettings = Model\Site::find(1)->getSettings();
            $return['image'] = $mainPageSettings['image'];
        }        
        
        if (!empty($param)) {
            
            $tmp = explode('.', $param);
            $subSettings = $return;
            foreach ($tmp as $val) {
                
                if (isset($subSettings[$val])) {
                    $subSettings = $subSettings[$val];
                } else {
                    return null;
                }
                
            }
            
            return $subSettings;
            
        }
        
        return $return;
    }        
}
