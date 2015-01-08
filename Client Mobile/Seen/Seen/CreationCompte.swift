//
//  CreationCompte.swift
//  Seen
//
//  Created by Cyril Py on 05/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class CreationCompte: UIViewController, UITextFieldDelegate {

    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    @IBOutlet weak var nom: UITextField!
    @IBOutlet weak var prenom: UITextField!
    @IBOutlet weak var mail: UITextField!
    @IBOutlet weak var pseudo: UITextField!
    @IBOutlet weak var mdp: UITextField!
    @IBOutlet weak var btnCreationCompte: UIButton!
    
    @IBAction func CreationCompte(sender: UIButton) {
        if (nom.text != "" && prenom.text != "" && mail.text != "" && pseudo.text != "" && mdp.text != ""){
            let url = NSURL(string: "http://perso.imerir.com/cpy/Seen/insertion.php?quoi=m&nom=" + nom.text + "&prenom=" + prenom.text + "&mail=" + mail.text + "&pseudo=" + pseudo.text + "&mdp=" + mdp.text)
            let task = NSURLSession.sharedSession().dataTaskWithURL(url!) {(data, response, error) in
                    var json = data;
                    var error: NSError? = nil
                    var jsonObject: AnyObject? = NSJSONSerialization.JSONObjectWithData(json!, options: NSJSONReadingOptions.allZeros, error: &error)
                    let code = (jsonObject as NSDictionary)["code"] as String
                
                
                if (code == "1"){
                    dispatch_async(dispatch_get_main_queue(), {
                        let storyboard = UIStoryboard(name: "Main", bundle: nil)
                        let vc = storyboard.instantiateViewControllerWithIdentifier("Connexion") as Connexion
                        vc.vPseudo = self.pseudo.text
                        vc.vMdp = ""
                        self.presentViewController(vc, animated: true, completion: nil)
                        
                    });
                }else{
                    println("Creation echouée: " + NSString(data: data, encoding: NSUTF8StringEncoding)!);
                }
                
            }
            task.resume()
            
        }else{
            dispatch_async(dispatch_get_main_queue(), {
                var alert = UIAlertController(title: "Création impossible", message: "Une ou plusieurs informations n'ont pas étés renseignées !", preferredStyle: UIAlertControllerStyle.Alert)
                alert.addAction(UIAlertAction(title: "Ok", style: UIAlertActionStyle.Default, handler: nil))
                self.presentViewController(alert, animated: true, completion: nil)
            });
        }
    }
    func textFieldShouldReturn(textField: UITextField!) -> Bool // called when 'return' key pressed. return NO to ignore.
    {
        if (textField.returnKeyType.rawValue == 4){ // 4 = "next", 0 = "return" || "default"
            switch textField {
            case nom : prenom.becomeFirstResponder()
                break;
            case prenom : mail.becomeFirstResponder()
                break;
            case mail : pseudo.becomeFirstResponder()
                break;
            case pseudo : mdp.becomeFirstResponder()
                break;
            default:
                break;
            }
            
            //textField.nextResponder()?.becomeFirstResponder()
        }else{
            textField.resignFirstResponder()
        }
        return true;
    }
}

