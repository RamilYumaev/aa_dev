<?php

namespace modules\exam\models\ones;

use Yii;

/**
 * This is the model class for table "faks".
 *
 * @property int $id
 * @property string|null $guid_postupayuschego
 * @property string|null $fio
 * @property string|null $pol
 * @property string|null $data_rozhdeniya
 * @property string|null $mesto_rozhdeniya
 * @property string|null $telefon
 * @property string|null $pochta
 * @property string|null $snils
 * @property string|null $dul
 * @property string|null $seriya
 * @property string|null $nomer
 * @property string|null $strana_vydachi
 * @property string|null $data_vydachi
 * @property string|null $guid_zayavleniya
 * @property string|null $istochnik
 * @property string|null $aktualnost
 * @property string|null $vuz
 * @property string|null $data_registracii
 * @property string|null $data_izmeneniya
 * @property string|null $neobhodimost_v_obschezhitii
 * @property string|null $specialnye_usloviya
 * @property string|null $muzykalniy_instrument
 * @property string|null $uid_konkursa
 * @property string|null $etap_priema
 * @property string|null $naimenovanie_konkursnoy_gruppy
 * @property string|null $forma_obucheniya
 * @property string|null $vid_mest
 * @property string|null $vybranniy_vid_sporta
 * @property string|null $prioritet
 * @property string|null $status
 * @property string|null $platniy_dogovor
 * @property string|null $podan_bumazhniy_original
 * @property string|null $podan_elektronniy_original
 * @property string|null $vuz_v_kotoriy_podan_original
 */
class Faks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['guid_postupayuschego', 'fio', 'pol', 'data_rozhdeniya', 'mesto_rozhdeniya', 'telefon', 'pochta', 'snils', 'dul', 'seriya', 'nomer', 'strana_vydachi', 'data_vydachi', 'guid_zayavleniya', 'istochnik', 'aktualnost', 'vuz', 'data_registracii', 'data_izmeneniya', 'neobhodimost_v_obschezhitii', 'specialnye_usloviya', 'muzykalniy_instrument', 'uid_konkursa', 'etap_priema', 'naimenovanie_konkursnoy_gruppy', 'forma_obucheniya', 'vid_mest', 'vybranniy_vid_sporta', 'prioritet', 'status', 'platniy_dogovor', 'podan_bumazhniy_original', 'podan_elektronniy_original', 'vuz_v_kotoriy_podan_original'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid_postupayuschego' => 'Guid Postupayuschego',
            'fio' => 'Fio',
            'pol' => 'Pol',
            'data_rozhdeniya' => 'Data Rozhdeniya',
            'mesto_rozhdeniya' => 'Mesto Rozhdeniya',
            'telefon' => 'Telefon',
            'pochta' => 'Pochta',
            'snils' => 'Snils',
            'dul' => 'Dul',
            'seriya' => 'Seriya',
            'nomer' => 'Nomer',
            'strana_vydachi' => 'Strana Vydachi',
            'data_vydachi' => 'Data Vydachi',
            'guid_zayavleniya' => 'Guid Zayavleniya',
            'istochnik' => 'Istochnik',
            'aktualnost' => 'Aktualnost',
            'vuz' => 'Vuz',
            'data_registracii' => 'Data Registracii',
            'data_izmeneniya' => 'Data Izmeneniya',
            'neobhodimost_v_obschezhitii' => 'Neobhodimost V Obschezhitii',
            'specialnye_usloviya' => 'Specialnye Usloviya',
            'muzykalniy_instrument' => 'Muzykalniy Instrument',
            'uid_konkursa' => 'Uid Konkursa',
            'etap_priema' => 'Etap Priema',
            'naimenovanie_konkursnoy_gruppy' => 'Naimenovanie Konkursnoy Gruppy',
            'forma_obucheniya' => 'Forma Obucheniya',
            'vid_mest' => 'Vid Mest',
            'vybranniy_vid_sporta' => 'Vybranniy Vid Sporta',
            'prioritet' => 'Prioritet',
            'status' => 'Status',
            'platniy_dogovor' => 'Platniy Dogovor',
            'podan_bumazhniy_original' => 'Podan Bumazhniy Original',
            'podan_elektronniy_original' => 'Podan Elektronniy Original',
            'vuz_v_kotoriy_podan_original' => 'Vuz V Kotoriy Podan Original',
        ];
    }
}
