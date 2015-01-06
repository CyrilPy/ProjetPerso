//
//  Recherche.swift
//  Seen
//
//  Created by Cyril Py on 06/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Recherche: UIViewController {
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func RetourAcceuil(sender: UIBarButtonItem) {
        let vc = Acceuil(nibName: "Acceuil", bundle: nil)
        self.navigationController?.pushViewController(vc, animated: true)
    }
}

