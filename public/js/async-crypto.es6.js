function GetErrorMessage(e) {
    let err = e.message;
    if (!err) {
        err = e;
    } else if (e.number) {
        err += " (" + e.number + ")";
    }
    return err;
}

function SignCreate(thumbprint, dataToSign) {
    return new Promise(function(resolve, reject){
        cadesplugin.async_spawn(function *(args) {
            try {

                cadesplugin.set_log_level(cadesplugin.LOG_LEVEL_INFO);
                // debugger;
                let oStore = yield cadesplugin.CreateObjectAsync("CAPICOM.Store");
                yield oStore.Open(CAPICOM_CURRENT_USER_STORE, CAPICOM_MY_STORE,CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED);

                let CertificatesObj = yield oStore.Certificates;
                let oCertificates = yield CertificatesObj.Find(
                    cadesplugin.CAPICOM_CERTIFICATE_FIND_SHA1_HASH, thumbprint);

                let Count = yield oCertificates.Count;
                let oCertificate = yield oCertificates.Item(1);
                let oSigner = yield cadesplugin.CreateObjectAsync("CAdESCOM.CPSigner");
                yield oSigner.propset_Certificate(oCertificate);
                yield oSigner.propset_Options(cadesplugin.CAPICOM_CERTIFICATE_INCLUDE_WHOLE_CHAIN);

                let oSignedData = yield cadesplugin.CreateObjectAsync("CAdESCOM.CadesSignedData");
                // let tspService =  "http://testca.cryptopro.ru/tsp/";

                yield oSignedData.propset_ContentEncoding(cadesplugin.CADESCOM_BASE64_TO_BINARY);
                // yield oSignedData.propset_Content(dataInBase64);

                yield oSignedData.propset_Content(dataToSign);
                // yield oSigner.propset_TSAAddress(tspService);
                let sSignedMessage = yield oSignedData.SignCades(oSigner, cadesplugin.CADESCOM_CADES_BES, true);

                yield oStore.Close();
                args[2](sSignedMessage);
                resolve(true);
            } catch (err) {
                reject(err);
            }
        }, thumbprint, dataToSign, resolve, reject);
    });
}

/**
 * Формирование строчки сертификата
 */
function CertificateAdjuster() {

    this.extract = function(from, what) {
        certName = "";

        let begin = from.indexOf(what);

        if(begin>=0)
        {
            let end = from.indexOf(', ', begin);
            certName = (end<0) ? from.substr(begin) : from.substr(begin, end - begin);
        }

        return certName;
    };

    this.Print2Digit = function(digit){
        return (digit<10) ? "0"+digit : digit;
    };

    this.GetCertDate = function(paramDate) {
        let certDate = new Date(paramDate);
        return this.Print2Digit(certDate.getUTCDate())+"."+this.Print2Digit(certDate.getMonth()+1)+"."+certDate.getFullYear() + " " +
                 this.Print2Digit(certDate.getUTCHours()) + ":" + this.Print2Digit(certDate.getUTCMinutes()) + ":" + this.Print2Digit(certDate.getUTCSeconds());
    };

    this.GetCertName = function(certSubjectName){
        return this.extract(certSubjectName, 'CN=');
    };

    this.GetIssuer = function(certIssuerName){
        return this.extract(certIssuerName, 'CN=');
    };

    this.GetCertInfoString = function(certSubjectName, certFromDate, issuedBy){
        return this.extract(certSubjectName,'CN=') + "; Выдан: " + this.GetCertDate(certFromDate) + " " + issuedBy;
    };

}

function FillCertList_NPAPI() {
   let certList = {};

   return new Promise(function(resolve, reject){
       cadesplugin.async_spawn(function *(args) {
               try {

                    let oStore = yield cadesplugin.CreateObjectAsync("CAPICOM.Store");
                    yield oStore.Open(CAPICOM_CURRENT_USER_STORE, CAPICOM_MY_STORE,CAPICOM_STORE_OPEN_MAXIMUM_ALLOWED);

                    let CertificatesObj = yield oStore.Certificates;
                    let Count = yield CertificatesObj.Count;

                    if (Count == 0) {
                        certList.globalCountCertificate = 0;
                        reject({certListNotFound: true});
                        return;
                    }

                    if (!Array.isArray(certList.globalOptionList)) {
                        certList.globalOptionList = [];
                    }

                    let text;
                    let dateObj = new Date();
                    let count = 0;

                      for (let i = 1; i <= Count; i++) {
                           let cert = yield CertificatesObj.Item(i);

                           let ValidToDate = new Date((yield cert.ValidToDate));
                           let ValidFromDate = new Date((yield cert.ValidFromDate));
                           let HasPrivateKey = yield cert.HasPrivateKey();
                           let Validator = yield cert.IsValid();
                           let IsValid = yield Validator.Result;

                           if( dateObj < new Date(ValidToDate) && IsValid && HasPrivateKey) {
                            let issuedBy = yield cert.GetInfo(1);
                            issuedBy = issuedBy || "";

                            text = new CertificateAdjuster().GetCertInfoString(yield cert.SubjectName, ValidFromDate, issuedBy);
                            certList.globalOptionList.push({
                                'value': text.replace(/^cn=([^;]+);.+/i, '$1'),
                                'text' : text.replace("CN=", ""),
                                'thumbprint' : yield cert.Thumbprint
                            });

                            count++;

                           }

                        }

                        certList.globalCountCertificate = count;
                        resolve(certList.globalOptionList, certList);

                } catch (err) {
                   reject(err);
                }
            });


    });

}
