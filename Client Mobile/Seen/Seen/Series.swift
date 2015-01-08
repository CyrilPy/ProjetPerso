//
//  Series.swift
//  Seen
//
//  Created by Cyril Py on 06/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Series: UIViewController {
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    @IBAction func RetourAcceuil(sender: UIBarButtonItem) {
        dispatch_async(dispatch_get_main_queue(), {
            let storyboard = UIStoryboard(name: "Main", bundle: nil)
            let vc = storyboard.instantiateViewControllerWithIdentifier("Acceuil") as Acceuil
            self.presentViewController(vc, animated: true, completion: nil)
        });
    }
}

