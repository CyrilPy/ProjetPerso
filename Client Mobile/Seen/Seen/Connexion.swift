//
//  Connexion.swift
//  Seen
//
//  Created by Cyril Py on 05/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Connexion: UIViewController, UITextFieldDelegate {
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBOutlet var pseudo: UITextField!
    @IBOutlet var mdp: UITextField!
    @IBOutlet var SeConnecter: UIButton!
    
    @IBAction func connexion(sender: UIButton) {
        
        let url = NSURL(string: "http://perso.imerir.com/cpy/Seen/connexion.php?pseudo=" + pseudo.text + "&mdp=" + mdp.text)
        let task = NSURLSession.sharedSession().dataTaskWithURL(url!) {(data, response, error) in
            
            if (NSString(data: data, encoding: NSUTF8StringEncoding) == "1"){
                dispatch_async(dispatch_get_main_queue(), {
                    let storyboard = UIStoryboard(name: "Main", bundle: nil)
                    let vc = storyboard.instantiateViewControllerWithIdentifier("Acceuil") as Acceuil
                    self.presentViewController(vc, animated: true, completion: nil)
                });
            
            }else{
                dispatch_async(dispatch_get_main_queue(), {
                    var alert = UIAlertController(title: "Connexion refusée", message: "Login et/ou mot de passe invalide(s)!", preferredStyle: UIAlertControllerStyle.Alert)
                    alert.addAction(UIAlertAction(title: "Ok", style: UIAlertActionStyle.Default, handler: nil))
                    self.presentViewController(alert, animated: true, completion: nil)
                });
                
            }
        }
        task.resume()
    }
    func textFieldShouldReturn(textField: UITextField!) -> Bool // called when 'return' key pressed. return NO to ignore.
    {
        textField.resignFirstResponder()
        return true;
    }
}
